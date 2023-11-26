import { defineStore } from 'pinia'

export const useTaskStore = defineStore({
  id: 'task',

  state: () => ({
    loading: true,
    data: {
      description: '',
      title: '',
      checklists: []
    },
    options: {},
    inWork: [],
    isContentForm: false,
    subtaskForm: null,
    checklistItemForm: null,
    commentForm: null,
    isContentFormDesc: false,
    isContentFormTitle: false,
    newSubtaskForm: false,
    newChecklistItemForm: false,
  }),

  actions: {
     fetch(payload) {
      if (typeof payload == 'number') {
        this.loading = true

         axios.get('tasks/' + payload)
          .then(data => {
            this.options = data.options
            this.data = data.task
            this.loading = false
          })
      } else {
        this.loading = true
         axios.get('tasks/' + payload.id)
          .then(data => {
            this.options = data.options
            this.data = data.task
            this.loading = false
          })
      }
    },
  }
})
