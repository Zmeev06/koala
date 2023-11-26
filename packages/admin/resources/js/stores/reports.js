import { defineStore } from 'pinia'

export const useReportsStore = defineStore({
  id: 'reports',

  state: () => ({
    filters: {
      users_id: [],
      projects_id: [],
      dates: [],
      order_name: 'updated_at',
      order_dir: 'desc'
    }
  }),

  actions: {
    pushId(payload) {
      if(this.filters[payload.name].includes(payload.value)){
        this.filters[payload.name] = this.filters[payload.name].filter(el => {
          return el != payload.value
        })
      } else {
        this.filters[payload.name].push(payload.value)
      }
    }
  }

})
