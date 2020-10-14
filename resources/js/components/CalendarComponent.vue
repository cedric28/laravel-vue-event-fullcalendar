<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <form @submit.prevent>
          <div class="form-group">
            <label for="event_name">Event Name</label>
            <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="start_date">Start Date</label>
                <input
                  type="date"
                  id="start_date"
                  class="form-control"
                  v-model="newEvent.start_date"
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <span v-for="item in days" v-bind:key="item.id">
                  <input type="checkbox" v-bind:id="item.id" :value="item.id" v-model="newEvent.week_day"> <label class="mr-2" v-bind:for="item.id">{{item.text}}</label>
                </span>
              </div>
            </div>
            <div class="col-md-6 mb-4" v-if="addingMode">
              <button class="btn btn-sm btn-primary" @click="addNewEvent">Save Event</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-8">
        <Fullcalendar :options="calendarOptions" />
      </div>
    </div>
  </div>
</template>

<script>
import Fullcalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import rrulePlugin from '@fullcalendar/rrule';
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";

export default {
  components: {
    Fullcalendar
  },
  data() {
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin, rrulePlugin ],
        initialView: 'dayGridMonth',
        events: []
      },
      days: [
        { id: 'mo' , text: 'Mon'   ,},
        { id: 'tu' , text: 'Tue'   ,},
        { id: 'we' , text: 'Wed'   ,},
        { id: 'th' , text: 'Thu'   ,},
        { id: 'fr' , text: 'Fri'   ,},
        { id: 'sa' , text: 'Sat'   ,},
        { id: 'su' , text: 'Sun'   ,},
      ],
     
      newEvent: {
        event_name: "",
        start_date: "",
        end_date: "",
        week_day: [] ,
      },
      addingMode: true
    };
  },
  mounted() {
    this.getEvents();

     Fire.$on('AfterCreate',() => {
        this.getEvents();
    });
  },
  methods: {
    addNewEvent() {
      axios
        .post("/api/calendar", {
          ...this.newEvent
        })
        .then((res) => {
          Fire.$emit('AfterCreate');
        
          toast.fire({
            icon: 'success',
            title: res.data.message
          })
      
        });
    },
    getEvents() {
      axios
        .get("/api/calendar")
        .then(resp => {
          this.calendarOptions.events = resp.data.data
          
        })
        .catch(err => console.log(err.response.data));
    },
    resetForm() {
      Object.keys(this.newEvent).forEach(key => {
        return (this.newEvent[key] = "");
      });
    }
  }
};
</script>

<style lang="css">
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";

.fc-title {
  color: #fff;
}

.fc-title:hover {
  cursor: pointer;
}
</style>

