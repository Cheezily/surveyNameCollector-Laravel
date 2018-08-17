<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="section-head">Survey Extra Credit</h3>
            <p v-if="submissionError" class="warning">
                There was an error on the server processing the request. 
                Please refresh the page and try again. You will not lose your
                participation credit.
            </p>
        </div>

        <transition name="fade">
            <div v-if="!finished" class="panel-body">
                <form id='mainForm' class="form-group mainForm" @submit.prevent="submitNames()">

                    <div v-if="mainList" class="row">
                        <div class="col-sm-12">
                            <label>
                                Select Your Instructor's Name From The List...
                                <span class="warning" v-if="noInstructorWarning">
                                    Please add an Instructor and Course Info
                                </span>
                            </label>
                        </div>

                        <div class="col-sm-8 col-xs-12">
                            <select v-model="selectedInstructor" @change="instructorSelected()"
                                id="instructor" class="instructorList form-control input-sm" name="instructor">
                                <option v-bind:value="0" disabled="true">Select Your University Affiliation</option>
                                <option DISABLED="true">─────────────────────────</option>
                                <template v-for="university in survey_json.universities">
                                    <option disabled="true">
                                        {{ university.name.toUpperCase() }}:
                                    </option>
                                    <option v-for="instructor in university.instructors" value="4"
                                        v-bind:key="instructor.id"
                                        v-bind:value="instructor">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ instructor.first_name }} {{ instructor.last_name }}
                                    </option>
                                    <option DISABLED="true"></option>
                                </template>
                            </select>
                        </div>
                        <div class="col-sm-4 col-xs-12 text-right">
                            <button 
                                @click.prevent="openManual()"
                                class="btn btn-sm btn-success">
                                Click Here if Your Instructor is Not Listed
                            </button>
                        </div>
                    </div>

                    <div v-else class="form-group">
                        <label>
                            ...Or Add Your Instructor and Course Manually
                            <span class="warning"
                                v-if="manualWarning">{{ manualWarning }}</span>
                            </label>
                            <span class="warning" v-if="noInstructorWarning">
                                <strong>Please add an Instructor and Course Info</strong>
                            </span>
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <input v-model="manualFirstName" 
                                    class='form-control input-sm' 
                                    placeholder="Instructor's First Name (Optional)"
                                    type="text">
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <input v-model="manualLastName" 
                                    class='form-control input-sm' 
                                    placeholder="Instructor's Last Name"
                                    type="text">
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <input v-model="manualCourse" 
                                    class='form-control input-sm'
                                    placeholder="Enter Course Name"
                                    type="text">
                            </div>
                            <div class="col-sm-3 col-xs-12 text-right">
                                <button @click.prevent="openManual()"
                                    class="btn btn-sm btn-warning">Cancel</button>
                                <button @click.prevent="addManually()"
                                    class="btn btn-sm btn-success">Add Instructor</button>
                            </div>
                        </div>
                    </div>

                    <template v-if="selectedInstructors.length > 0">
                        <hr>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="section-head">
                                    Instructor(s) Added:
                                    <span class="warning" v-if="courseWarning">
                                        Please make sure to include the course name
                                        for all instructors
                                    </span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="row instructorListHeading">
                                        <div class="col-md-5">
                                            <label>Professor Name</label>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Course You're getting Extra Credit In</label>
                                        </div>
                                    </div>
                                    <div class="row instructorInfo" v-for="(instructor, id) in selectedInstructors" 
                                        v-bind:key="id">
                                        <div class="col-sm-5 col-xs-12">
                                            <p class="selectedName">
                                                <strong>{{ instructor.first_name }} 
                                                    {{ instructor.last_name }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-sm-5 col-xs-11">
                                            <input type="text" 
                                                class="form-control input-sm"
                                                v-model="selectedInstructors[id].course"
                                                @change="setCourse(id)"
                                                placeholder="Enter Course Name...">
                                        </div>
                                        <div class="col-sm-2 col-xs-2">
                                            <span @click="removeInstructor(id)"
                                                class="pull-right deleteInstructor 
                                                glyphicon glyphicon-remove-circle">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="studentfirst">
                                    Enter Your Name
                                    <span v-if="yourNameWarning" class="warning">
                                        Please Enter Your First And Last name
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <input class='form-control input-sm' 
                                    placeholder="Your First Name"
                                    v-model="yourFirstName"
                                    type="text">
                            </div>
                            <div class="col-sm-5 col-xs-12">
                                <input class='form-control input-sm' 
                                    placeholder="Your Last Name"
                                    v-model="yourLastName"
                                    type="text">
                            </div>
                            <div class="col-sm-2 col-xs-12 text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div v-else class="panel-body">
                <h2>Thanks!</h2>
                <h4>Your instructor will be notified soon.  You can close this window.</h4>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['survey', 'url'],
        data() {
            return {
                mainList: true,
                finished: false,
                survey_json: JSON.parse(this.survey),
                selectedInstructor: 0,
                mounted: '',
                selectedInstructors: [],
                manualFirstName: '',
                manualLastName: '',
                manualCourse: '',
                yourFirstName: '',
                yourLastName: '',
                yourNameWarning: false,
                manualWarning: '',
                courseWarning: false,
                noInstructorWarning: false,
                submissionError: false
            } 
        },
        mounted() {
            this.mounted = 'true'
            console.log(this.url)
            console.log(this.survey)
        },
        methods: {
            openManual() {
                this.mainList = !this.mainList
            },
            instructorSelected() {
                this.noInstructorWarning = ''
                let alreadySelected = false

                for(let i = 0; i < this.selectedInstructors.length; i++) {
                    if (this.selectedInstructor.id === this.selectedInstructors[i].id) {
                        alreadySelected = true
                    }
                }

                const instructor = this.selectedInstructor
                instructor.course = ''

                if (!alreadySelected) {
                    this.selectedInstructors.push(instructor)
                }
                this.selectedInstructor = 0
            },
            removeInstructor(id) {
                this.selectedInstructors.splice(id,1)
            },
            setCourse(id) {
                console.log(id)
                console.log(this.selectedInstructors)
            },
            addManually() {
                this.manualWarning = ''
                this.noInstructorWarning = false
                this.yourNameWarning = false
                const instructor = []
                instructor.id = this.selectedInstructors.length
                instructor.first_name = this.manualFirstName

                if (!this.manualCourse) {
                    this.manualWarning = 'Course Info Required'
                }

                if (!this.manualLastName) {
                    this.manualWarning = 'Instructor Last Name Required'
                }

                if (!this.manualWarning) {
                    instructor.last_name = this.manualLastName
                    instructor.course = this.manualCourse
                    this.selectedInstructors.push(instructor)
                    this.manualFirstName = ''
                    this.manualLastName = ''
                    this.manualCourse = ''
                }
            },
            submitNames() {
                this.manualWarning = ''
                this.courseWarning = ''
                this.noInstructorWarning = ''
                this.courseWarning = false
                this.yourNameWarning = false
                this.submissionError = false
                
                console.log(this.selectedInstructors)

                axios.post(this.url + '/savenames',
                    {
                        'instructors': this.selectedInstructors,
                        'participant_firstname': this.yourFirstName,
                        'participant_lastname': this.yourLastName,
                    })
                    .then(res => {
                        console.log(res)
                        if (res['status'] === 'success') {
                            this.finished = true
                        } else {
                            if (res['data'].errors) {
                                for (let i = 0; i < res['data'].errors.length; i++) {
                                    if (res['data'].errors[i] === 'yourName') {
                                        this.yourNameWarning = true
                                    }
                                    if (res['data'].errors[i] === 'noInstructors') {
                                        this.noInstructorWarning = true
                                    }
                                    if (res['data'].errors[i] === 'courseWarning') {
                                        this.courseWarning = true
                                    }
                                }
                            }
                        }
                    })
                    .catch(err => {
                        console.log('ERRORRRR' + err)
                        this.submissionError = true
                    })
            }
        }
    }
</script>

<style scoped>
    .selectedName {
        margin-top: 3px;
        margin-bottom: -5px;
    }
    .instructorListHeading {
        margin: -8px auto;
    }
    .instructorInfo {
        background: rgba(245,245,245,1);
        border: 1px solid #ccc;
        padding: 3px 0;
        margin: 4px auto;
        border-radius: 5px;
        box-shadow: 1px 2px #ccc;
    }
    .instructorInfo:hover {
        background: rgba(230,230,230,1);
    }
    .deleteInstructor {
        color: darkred;
        opacity: .6;
        font-size: 28px;
    }
    .deleteInstructor:hover {
        color: red;
        opacity: 1;
    }
    .warning {
        color: red;
    }
    .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    }
</style>
