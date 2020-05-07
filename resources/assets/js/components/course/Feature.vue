<template>
    <div>
        <div
            v-for="(feature,i) in localFeature"
            :key="i"
            class="input-group mb-3 feature"
        >
            <input
                id="value"
                name="value"
                class="form-control "
                placeholder=""
                :value="feature"
                @input="inputFeature($event.target.value, i)"
            >
            <div
                v-if="localFeature.length>1"
                class="input-group-append"
            >
                <span
                    id="basic-addon2"
                    class="input-group-text"
                ><a
                    href="#"
                    class=" ea-icon text-danger"
                    @click.prevent="deleteFeature(i)"
                ><i class="fas fa-trash-alt" /></a></span>
            </div>
        </div>
        <button
            type="button"
            class="feature-button btn btn-info btn-sm mt-1"
            @click.prevent="newfeature"
        >
            Add Features
        </button>
    </div>
</template>
<script>
export default {
    props: {
        value: {
            required: true,
            validator: v => typeof v === 'object'
        }
    },
    data () {
        return {
            localFeature: []
        }
    },
    mounted () {
        if (this.value && this.value.length) {
            this.localFeature = this.value
        } else {
            this.localFeature.push('')
        }
    },
    methods: {
        inputFeature (text, i) {
            this.localFeature[i] = text
            this.$emit('input', this.localFeature)
        },
        newfeature () {
            this.localFeature.push('')
        },
        deleteFeature (i) {
            this.localFeature.splice(i, 1)
        }
    }
}
</script>
