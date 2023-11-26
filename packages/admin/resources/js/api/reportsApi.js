import axios from "axios";

export async function fetchGetTasks(url) {
  const out = await axios({
    method: 'get',
    url: url,
  }).then(res => {
    return res
  })
  return out
}

export async function fetchGetAllUsers() {
  const out = await axios({
    method: 'get',
    url: '/api/reports/get-users',
  }).then(res => {
    return res
  })
  return out
}

export async function fetchGetAllProjects() {
  const out = await axios({
    method: 'get',
    url: '/api/reports/get-projects',
  }).then(res => {
    return res
  })
  return out
}
