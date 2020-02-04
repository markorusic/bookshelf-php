import axios from 'axios'

export default {
  fetchAll: () => axios.get('/api/categories/findAll').then(res => res.data)
}
