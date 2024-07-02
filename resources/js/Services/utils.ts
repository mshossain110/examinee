import { defu, createDefu } from 'defu'
import { extendTailwindMerge } from 'tailwind-merge'
import type { Strategy } from '../types'

const customTwMerge = extendTailwindMerge<string, string>({
  extend: {
    classGroups: {
      icons: [(classPart: string) => /^i-/.test(classPart)]
    }
  }
})

const defuTwMerge = createDefu((obj, key, value, namespace) => {
  if (namespace === 'default' || namespace.startsWith('default.')) {
    return false
  }
  if (namespace === 'popper' || namespace.startsWith('popper.')) {
    return false
  }
  if (namespace.endsWith('avatar') && key === 'size') {
    return false
  }
  if (namespace.endsWith('chip') && key === 'size') {
    return false
  }
  if (namespace.endsWith('badge') && key === 'size' || key === 'color' || key === 'variant') {
    return false
  }
  if (typeof obj[key] === 'string' && typeof value === 'string' && obj[key] && value) {
    // @ts-ignore
    obj[key] = customTwMerge(obj[key], value)
    return true
  }
})

export function mergeConfig<T> (strategy: Strategy, ...configs: any): T {
  if (strategy === 'override') {
    return defu({}, ...configs) as T
  }

  return defuTwMerge({}, ...configs) as T
}

export function hexToRgb (hex: string) {
  // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
  const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i
  hex = hex.replace(shorthandRegex, function (_, r, g, b) {
    return r + r + g + g + b + b
  })

  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex)
  return result
    ? `${parseInt(result[1], 16)} ${parseInt(result[2], 16)} ${parseInt(result[3], 16)}`
    : null
}

export function getSlotsChildren (slots: any) {
  let children = slots.default?.()
  if (children?.length) {
    children = children.flatMap((c: any )=> {
      if (typeof c.type === 'symbol') {
        if (typeof c.children === 'string') {
          // `v-if="false"` or commented node
          return
        }
        return c.children
      } else if (c.type.name === 'ContentSlot') {
        return c.ctx.slots.default?.()
      }
      return c
    }).filter(Boolean)
  }
  return children || []
}

/**
 * "123-foo" will be parsed to 123
 * This is used for the .number modifier in v-model
 */
export function looseToNumber (val: any): any {
  const n = parseFloat(val)
  return isNaN(n) ? val : n
}

export function omit<T extends Record<string, any>, K extends keyof T> (
    object: T,
    keysToOmit: K[] | any[]
  ): Pick<T, Exclude<keyof T, K>> {
    const result = { ...object }
  
    for (const key of keysToOmit) {
      delete result[key]
    }
  
    return result
  }
  
  export function get (object: Record<string, any>, path: (string | number)[] | string, defaultValue?: any): any {
    if (typeof path === 'string') {
      path = path.split('.').map(key => {
        const numKey = Number(key)
        return isNaN(numKey) ? key : numKey
      })
    }
  
    let result: any = object
  
    for (const key of path) {
      if (result === undefined || result === null) {
        return defaultValue
      }
  
      result = result[key]
    }
  
    return result !== undefined ? result : defaultValue
  }

  export function useId(prefix?: string, length: number = 10): string {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return prefix ? prefix.concat(result) : result;
  }
