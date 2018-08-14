<template>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="section-head">Survey Extra Credit</h4>
          <p>Please select the instructor offering extra credit for your participation.</p>
        </div>
        <div class="panel-body">
            <form id='mainForm' class="form-group mainForm" @submit.prevent="saveNames()">
                <label for="instructor">Your Instructor's Name</label>
                <select v-model="selectedInstructor" @change="instructorSelected()"
                    id="instructor" class="instructorList form-control input-sm" name="instructor">
                    <option disabled="true">Select Your University Affiliation</option>
                    <option DISABLED="true">─────────────────────────</option>
                    <template v-for="university in survey_json.universities">
                        <option disabled="true">
                            {{ university.name.toUpperCase() }}:
                        </option>
                        <option v-for="instructor in university.instructors" v-bind:key="instructor.id">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            {{ instructor.first_name }} {{ instructor.last_name }}
                        </option>
                        <option DISABLED="true"></option>
                    </template>
                </select>
                <hr>
                <label for="studentfirst">Your First Name</label>
                <input class='form-control input-sm' type="text" id='studentfirst' name="studentfirst" required>
                <label for="studentfirst">Your Last Name</label>
                <input class='form-control input-sm' type="text" id='studentfirst' name="studentlast" required>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['survey'],
        data() {
            return {
                survey_json: JSON.parse(this.survey),
                selectedInstructor: '',
                mounted: ''
            } 
        },
        mounted() {
            this.mounted = 'true'
        },
        methods: {
            instructorSelected(instructor) {
                console.log(instructor)
            }
        }
    }
</script>
