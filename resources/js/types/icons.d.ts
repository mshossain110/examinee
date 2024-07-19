import * as solid from "@heroicons/vue/24/solid";
export type CustomIconName = "LoadingIcon";

export type HeroIconName = keyof typeof solid

export type IconName = HeroIconName | CustomIconName;