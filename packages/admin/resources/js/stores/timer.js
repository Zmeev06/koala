import { defineStore } from 'pinia'

let timerInterval

export const useTimerStore = defineStore({
  id: 'timer',

  state: () => ({
    taskId: '',
    projectId: '',
    projectName: '',
    taskTitle: '',
    processing: false,
    timers: [],
    isTimerRunning: false,
    timerStartedAt: null,
    timerStoppedAt: null,
    currentTaskTimer: {
      h: 0,
      m: 0,
      s: 0,
    }
  }),

  actions: {
    start(task) {
      // this.stopPrev()
      this.startTimer();
        const taskId = task.id;
        const projectId = task.project_id;

      axios.post('time-task', {
        taskId: taskId,
        projectId: projectId,
        start: true,
        currentTime: this.timerStartedAt,
      })
        .then(data => {
          this.processing = false
          this.fetch()
        })
        .catch(error => {
          this.processing = false
        })
    },

      complete(task){

        this.stopTimer();

          const taskId = task.id;
          const projectId = task.project_id;

          axios.post('time-task', {
              taskId: taskId,
              projectId: projectId,
              complete: true,
              currentTime: this.timerStoppedAt,
          })
              .then(data => {
                  this.processing = false
                  this.fetch()
              })
              .catch(error => {
                  this.processing = false
              })
      },

    stop(task) {
      this.stopTimer()

      const taskId = task.id;
      const projectId = task.project_id;
      this.processing = true

      axios.post('time-task', {
        taskId: taskId,
        projectId: projectId,
        stop: true,
        currentTime: this.timerStoppedAt,
      })
        .then(data => {
          this.processing = false
          this.fetch()
        })
        .catch(error => {
          this.processing = false
        })

      this.taskId = null
      this.projectId = null
      this.projectName = null
    },

    stopPrev() {
      if (!this.taskId) return
      this.stopTimer()

      const taskId = this.taskId
      const projectId = this.projectId
      this.processing = true

      axios.post('time-logs', {
        taskId: taskId,
        projectId: projectId,
        stop: true,
        currentTime: this.timerStoppedAt,
        text: 'text1',
      })
        .then(data => {
          console.log(data)
        })
        .catch(error => {
          console.log('error')
          this.processing = false
        })
    },

    fetch() {
      axios.get('time-logs')
        .then(data => {
          this.timers = data

          const task = data.find(x => x.user.id == Config.user.id)

          if (task) {
            this.taskId = task.id
            this.taskTitle = task.title
            this.projectId = task.project_id
            this.projectName = 'Test'
          }
        })
    },

    startTimer() {
        this.timerStartedAt = new Date()
      timerInterval = setInterval(() => {
        if (this.currentTaskTimer.s == 59) {
          this.currentTaskTimer.s = 0
          this.currentTaskTimer.m++
        } else if (this.currentTaskTimer.m == 59) {
          this.currentTaskTimer.m = 0
          this.currentTaskTimer.h++
        } else {
          this.currentTaskTimer.s++
        }
      }, 1000)
      this.isTimerRunning = true
    },

    stopTimer() {
      clearInterval(timerInterval)

      this.timerStoppedAt = new Date()
      this.isTimerRunning = false
    },

    setTimer(timestamp) {
      this.isTimerRunning = false

      var hours = Math.floor(timestamp / 60 / 60);
      var minutes = Math.floor(timestamp / 60) - (hours * 60);
      var seconds = timestamp % 60;

      this.currentTaskTimer.s = seconds
      this.currentTaskTimer.m = minutes
      this.currentTaskTimer.h = hours
    },
  }
})
