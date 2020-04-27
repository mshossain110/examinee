<template>
    <div class="single-exam exam">
        <section class="exam-bord">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h4>REASONING : QUESTION 1 OF 16</h4>
                    <div class="time">
                        <strong>Rmaining Time: 42:10</strong>
                        <strong>Total Time : 50:00</strong>
                    </div>
                </div>

                <div class="card-body px-5">
                    <div class="row mt-5">
                        <div class="col">
                            <div class="question d-flex">
                                <p>1.Wthat is your  name?</p>
                                <strong>Mark : 5.0</strong>
                            </div>
                        </div>    
                    </div>

                    <div class="row mt-5">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <input type="checkbox" aria-label="Radio button for following text input">
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with radio button">
                            </div>
                        </div>      
                    </div>

                    <div class="row mt-5">
                        <div class="col">
                            <div class="next-button">
                                <button type="button" class="btn btn-outline-success">Preview</button>
                                <button type="button" class="btn btn-outline-dark">Mark For Review</button>
                                <button type="button" class="btn btn-outline-success">Next</button>
                                <button type="button" class="btn btn-outline-dark">Clear Ans</button>
                                <button type="button" class="btn btn-outline-danger">Finish</button>
                            </div>
                        </div>        
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div>
                               <h5>QUESTIONS</h5>
                            </div> 
                        </div>
                        <div class="col-12">
                             <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">                
                                <button type="button" class="btn btn-primary mr-1">1</button>
                                <button type="button" class="btn btn-primary mr-1">2</button>
                                <button type="button" class="btn btn-primary mr-1">3</button>
                                <button type="button" class="btn btn-primary mr-1">4</button>
                                <button type="button" class="btn btn-primary mr-1">5</button>
                                <button type="button" class="btn btn-primary mr-1">6</button>
                                <button type="button" class="btn btn-primary mr-1">7</button>
                                <button type="button" class="btn btn-primary mr-1">8</button>
                                <button type="button" class="btn btn-primary mr-1">9</button>
                                <button type="button" class="btn btn-primary mr-1">10</button>     
                            </div>
                        </div>          
                    </div>

                </div>  

            </div>

        </section>
        <section class="details">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="list-group list-group-horizontal-lg">
                                <a class="list-group-item">
                                    Overview
                                </a>
                                <a class="list-group-item">
                                    Author
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="overview">
                                <h3 class="text-uppercase">
                                    ABOUT THIS exam
                                </h3>
                                <strong>{{ exam.title }}</strong>

                                <h3 class="text-uppercase">
                                    Details
                                </h3>

                                <div>{{ exam.description }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    components: {
    },
    data: () => ({
        loading: false,
        exam: {}
    }),
    watch: {
        '$route' () {
            this.getExam()
        }
    },
    created () {
        this.getExam()
    },
    methods: {
        getExam () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.exam
            }

            axios.get(`/api/exam/${params.id}`, { params })
                .then(res => {
                    this.exam = res.data.data
                    this.loading = false
                })
        }
    }
}
</script>
