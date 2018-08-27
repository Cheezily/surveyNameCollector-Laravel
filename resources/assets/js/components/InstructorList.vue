<template>
<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="section-head">
                Survey Extra Credit
                - {{ selectedInstructors.length }} Instructors Added
            </h3>
            <p v-if="submissionError" class="warning">
                There was an error on the server processing the request. 
                Please refresh the page and try again. You will not lose your
                participation credit.
            </p>
            <p v-if="universityWarning" class="warning">
                Please make sure all instructors have their univeristy listed.
            </p>
        </div>
    </div>

    <transition name="replace" mode="in-out" v-bind:key="finished">
        <div v-if="instructorPanelOpen || selectedInstructors.length === 0" v-bind:key="finished" class='panel panel-default'>
            <div class="panel-body">
                <form id='mainForm' class="form-group mainForm" @submit.prevent="submitNames()">
                    <transition name="fade" mode="out-in">
                        <div v-if="mainList" v-bind:key="mainList" class="row">
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
                                    class="form-control input-sm">
                                    <option v-bind:value="0" disabled="true">Select Your University Affiliation</option>
                                    <option DISABLED="true">─────────────────────────</option>
                                    <template v-for="university in survey_json.universities">
                                            <option disabled="true">
                                                {{ university.name.toUpperCase() }}:
                                            </option>
                                            <option v-for="instructor in university.instructors"
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

                        <div v-else v-bind:key="mainList" class="form-group">
                            <p class="warning" v-if="manualWarning">
                                <strong>{{ manualWarning }}</strong>
                            </p>
                            <div class="row">
                                <div class="col-md-5">
                                    <label>
                                        Select Your University
                                    </label>
                                </div>
                                <transition name="fade" v-bind:key="universityNotListed">
                                    <div class="col-md-6" v-if="universityNotListed">
                                        <label>
                                            Enter The Name Of Your University
                                        </label>
                                    </div>
                                </transition>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <select v-model="manualUniversitySelected"
                                        class="instructorList form-control input-sm">
                                        <option v-bind:value="0" disabled="true">Select Your University Affiliation</option>
                                        <option DISABLED="true">─────────────────────────</option>
                                        <template>
                                            <option v-for="university in universities" 
                                                v-bind:key="university.id" v-bind:value="university">
                                                {{ university.name }}
                                            </option>
                                        </template>
                                        <option DISABLED="true">─────────────────────────</option>
                                        <option v-bind:value="-1">UNIVERSITY NOT LISTED</option>
                                    </select>
                                </div>
                                <transition name="fade" v-bind:key="universityNotListed">
                                    <div class="col-md-6" v-if="universityNotListed">
                                        <input type="text" class="form-control input-sm"
                                            v-model="manualUniversityNameOnly"
                                            placeholder="Enter University Name">
                                    </div>
                                </transition>
                            </div>

                            <hr>
                            
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
                                        @change="checkToOpenNamePanel()"
                                        placeholder="Enter Course Name"
                                        type="text">
                                </div>
                                <div class="col-sm-3 col-xs-12 text-right">
                                    <button @click.prevent="addManually()"
                                        class="btn btn-sm btn-success pull-right">Add Instructor</button>
                                    <button @click.prevent="openManual()"
                                        class="btn btn-sm btn-warning back_button">
                                        <span class="glyphicon glyphicon-arrow-left"></span>
                                        Back
                                    </button>
                                </div>
                            </div>
                        </div>
                    </transition>
                </form>
            </div>
        </div>
    </transition>

    <transition name="replace" mode="in-out">
        <template v-if="selectedInstructors.length > 0 && !finished">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="section-head">
                            <div class='row'>
                                <div class='col-xs-12 col-sm-3'>
                                    Instructor(s) Added:
                                    <span class="warning" v-if="courseWarning">
                                        Please make sure to include the course name
                                        for all instructors
                                    </span>
                                </div>
                                <div class="col-xs-12 col-sm-9 text-right">
                                    <button @click="closeInstructorPanel = !closeInstructorPanel"
                                        class="btn btn-sm btn-info"
                                    >
                                        Click Here To Add More Instructors
                                    </button>
                                    <button v-if="selectedInstructors.length > 0 && !closeInstructorPanel"
                                        @click.prevent="closeInstructorPanel = !closeInstructorPanel"
                                        class="btn btn-sm btn-warning">
                                        Click Here if You Are Done Adding Instructors
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <label>What's the Course Name?</label>
                                </div>
                            </div>
                            <div class="row instructorInfo" v-for="(instructor, id) in selectedInstructors" 
                                v-bind:key="id">
                                <div class="col-sm-7 col-xs-12">
                                    <p class="selectedName">
                                        <strong>{{ instructor.first_name }} 
                                            {{ instructor.last_name }}</strong>
                                            -
                                        <span>{{ instructor.university_name }}</span>
                                        <transition name="fade" mode="out-in">
                                            <span 
                                                v-if="(instructor.course.length < 1)"
                                                class="warning pull-right">
                                                (Needs Course Info)
                                            </span>
                                        </transition>
                                    </p>
                                </div>
                                <div class="col-sm-4 col-xs-10">
                                    <input type="text" 
                                        class="form-control input-sm courseName"
                                        v-model="selectedInstructors[id].course"
                                        @keyup="checkToOpenNamePanel(id)"
                                        placeholder="Enter Course Name...">
                                </div>
                                <div class="col-sm-1 col-xs-1 pull-right">
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
    </transition>

    <transition name="replace" mode="in-out">
        <div v-if="openNamePanel && !finished && selectedInstructors.length > 0"        
            class="panel panel-default">
            <div class="panel-body">
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
                            <button type="submit"
                                @click="submitNames()"
                                v-if="selectedInstructors.length > 0"
                                class="btn btn-sm btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>

    <transition name="replace" mode="in-out">
        <div v-if="finished" class="panel-body" v-bind:key="finished">
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
                universities: [],
                selectedInstructor: 0,
                manualUniversitySelected: 0,
                mounted: '',
                selectedInstructors: [],
                manualUniversityNameOnly: '',
                manualFirstName: '',
                manualLastName: '',
                manualCourse: '',
                yourFirstName: '',
                yourLastName: '',
                yourNameWarning: false,
                manualWarning: '',
                courseWarning: false,
                universityWarning: false,
                noInstructorWarning: false,
                submissionError: false,
                firstManualPage: true,
                secondManualPage: false,
                closeInstructorPanel: false,
                openNamePanel: false
            } 
        },
        mounted() {
            this.mounted = 'true'
            this.survey_json.universities.forEach(university => {
                this.universities.push(university)
            });
        },
        computed: {
            universityNotListed() {
                return this.manualUniversitySelected === -1
            },
            instructorPanelOpen() {
                return (this.selectedInstructors.length < 0) || !this.closeInstructorPanel
            }
        },
        watch: {
            selectedInstructors() {
                let allHaveCourses = true
                this.selectedInstructors.forEach(function (instructor) {
                    if (instructor.course.length < 1) {
                        allHaveCourses = false
                    }
                })
                
                if (allHaveCourses) {
                    this.openNamePanel = true
                } else {
                    this.openNamePanel = false
                }
            }
        },
        methods: {
            openManual() {
                this.mainList = !this.mainList
            },
            checkToOpenNamePanel() {
                let allHaveCourses = true
                this.selectedInstructors.forEach(function (instructor) {
                    if (instructor.course.length < 1) {
                        allHaveCourses = false
                    }
                })
                
                if (allHaveCourses) {
                    this.openNamePanel = true
                } else {
                    this.openNamePanel = false
                }
            },
            instructorSelected() {
                console.log(this.selectedInstructor)

                this.noInstructorWarning = ''
                let alreadySelected = false

                this.selectedInstructors.forEach(instructor => {
                    if (instructor.id === this.selectedInstructor.id) {
                        alreadySelected = true
                    }
                })

                let university_name = ''
                let university_id = 0
                this.survey_json['universities'].forEach(university => {
                    if (university.id === this.selectedInstructor.university_id) {
                        university_name = university.name
                        university_id = university.id
                    }
                })

                const instructor = this.selectedInstructor
                instructor.course = ''
                instructor.university_name = university_name
                instructor.university_id = university_id

                if (!alreadySelected) {
                    this.selectedInstructors.push(instructor)
                }
                this.selectedInstructor = 0
                this.closeInstructorPanel = true
            },
            removeInstructor(id) {
                this.selectedInstructors.splice(id,1)
            },
            addManually() {
                this.manualWarning = ''
                this.noInstructorWarning = false
                this.yourNameWarning = false
                let instructor = {}
                instructor.student_added = 1
                instructor.first_name = this.manualFirstName

                if (!this.manualCourse) {
                    this.manualWarning = 'Course Info Required'
                }

                if (!this.manualLastName) {
                    this.manualWarning = 'Instructor Last Name Required'
                }

                if ((this.manualUniversitySelected === 0 ||
                    this.manualUniversitySelected === -1)
                    && !this.manualUniversityNameOnly) {
                    this.manualWarning = 'University Info Required'
                }

                if (!this.manualWarning) {
                    instructor.last_name = this.manualLastName
                    instructor.course = this.manualCourse
                    instructor.id = -1
                    instructor.survey_id = this.survey_json.id
                    if (this.manualUniversityNameOnly.trim()) {
                        instructor['university_id'] = -1
                        instructor.university_name = this.manualUniversityNameOnly.trim()
                    }
                    if (this.manualUniversitySelected !== 0 && this.manualUniversitySelected !== -1) {
                        instructor.university_name = this.manualUniversitySelected.name
                        instructor.university_id = this.manualUniversitySelected.id
                    }
                    //console.log(instructor)
                    this.selectedInstructors.push(instructor)
                    this.manualFirstName = ''
                    this.manualLastName = ''
                    this.manualCourse = ''
                    this.manualUniversityNameOnly = ''
                    this.manualUniversitySelected = 0
                    this.closeInstructorPanel = true
                }
            },
            submitNames() {
                this.manualWarning = ''
                this.courseWarning = ''
                this.noInstructorWarning = ''
                this.courseWarning = false
                this.yourNameWarning = false
                this.submissionError = false
                
                //console.log(this.selectedInstructors)

                axios.post(this.url + '/savenames',
                    {
                        'instructors': this.selectedInstructors,
                        'participant_firstname': this.yourFirstName,
                        'participant_lastname': this.yourLastName,
                    })
                    .then(res => {
                        console.log(res['data'])
                        console.log(res['data']['errors'])
                        if (res.data.status === 'success') {
                            this.finished = true
                            this.manualWarning = ''
                            this.courseWarning = ''
                            this.noInstructorWarning = ''
                            this.courseWarning = false
                            this.yourNameWarning = false
                            this.submissionError = false
                        } else {
                            if (res['data']['errors']) {
                                res['data']['errors'].forEach(error => {
                                    if (error === 'yourName') {
                                        this.yourNameWarning = true
                                        console.log('participant name warning tripped')
                                    }
                                    if (error === 'noInstructors') {
                                        this.noInstructorWarning = true
                                        console.log('"no instructors" warning tripped')
                                    }
                                    if (error === 'courseWarning') {
                                        this.courseWarning = true
                                        console.log('course warning tripped')
                                    }
                                    if (error === 'universityWarning') {
                                        this.universityWarning = true
                                        console.log('university warning tripped')
                                    }
                                })
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
        margin-top: 5px;
        margin-bottom: -5px;
    }
    @media only screen and (max-width: 600px) {
        .selectedName {
            margin-bottom: 5px;
        }
        input, button {
            margin-top: 3px;
        }
    }
    .instructorInfo {
        background: rgba(245,245,245,1);
        border: 1px solid #ccc;
        padding: 5px 0;
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
        transition: all .2s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }

    .replace-enter-active {
        transition: all .2s;
        transition-delay: .3s;
    }
    .replace-leave-active {
        transition: all .2s;
    }
    .replace-enter, .replace-leave-to {
        opacity: 0;
    }

    .back_button {
        margin-right: 3px;
    }
    .courseName {
        margin-top: 0;
    }
</style>
