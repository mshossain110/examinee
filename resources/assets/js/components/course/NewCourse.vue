<template>
    <div class="new-course mb-5">
        <div class="card p-3">
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input
                            id="title"
                            type="text"
                            class="form-control"
                            aria-describedby="emailHelp"
                            placeholder="Course Title"
                        >
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input
                            id="slug"
                            type="text"
                            class="form-control"
                            aria-describedby="slugHelp"
                            placeholder="Course slug"
                        >
                        <small
                            id="emailHelp"
                            class="form-text text-muted"
                        >Try To Create SEO Frindly URL</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">Description</label>
                        <textarea
                            id="description"
                            placeholder=""
                            name="description"
                            class="form-control "
                        />
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input
                            id="price"
                            type="number"
                            class="form-control"
                            aria-describedby="priceHelp"
                            placeholder="Course Price"
                        >
                    </div>
                    <div class="form-group">
                        <label
                            for="course_image"
                            class="control-label"
                        >Course image</label>
                        <input
                            id="course_image"
                            name="course_image"
                            type="file"
                            class="form-control"
                            style="margin-top: 4px;"
                        >
                        <input
                            name="course_image_max_size"
                            type="hidden"
                            value="8"
                        >
                        <input
                            name="course_image_max_width"
                            type="hidden"
                            value="4000"
                        >
                        <input
                            name="course_image_max_height"
                            type="hidden"
                            value="4000"
                        >
                        <p class="help-block" />
                    </div>
                    <div class="form-group">
                        <label
                            for="start_date"
                            class="control-label"
                        >Start date</label>
                        <input
                            id="start_date"
                            placeholder=""
                            name="start_date"
                            type="date"
                            class="form-control date"
                        >
                        <p class="help-block" />
                    </div>
                    <div class="form-group form-check">
                        <input
                            id="published"
                            name="published"
                            type="checkbox"
                            class="form-check-input"
                            value="0"
                        >
                        <label
                            for="published"
                            class="control-label"
                        >Published</label>
                    </div>
                    <div class="form-group">
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {

        }
    },
    computed: {

    },
    created () {

    },
    methods: {

    }
}
</script>
