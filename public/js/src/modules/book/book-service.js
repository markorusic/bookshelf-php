import axios from 'axios'
import { wait } from '../../shared/utils'

const INITIAL_STATE = {
  items: [],
  isLoading: false,
  isLoaded: false,
  error: null,
  loadingPromise: null
}

let state = INITIAL_STATE
const setState = newState => {
  state = { ...state, ...newState }
}

export default {
  fetchAll() {
    if (state.isLoaded) {
      return Promise.resolve(state.items)
    }
    if (!state.isLoading) {
      setState({
        isLoading: true,
        loadingPromise: axios
          .get('/api/books/findAll')
          .then(res => {
            setState({
              items: res.data,
              isLoaded: true,
              isLoading: false,
              error: null
            })
            return state.items
          })
          .catch(error => {
            setState({
              isLoading: false,
              error
            })
            console.warn('Error fetching books data!')
            console.log(error)
            return Promise.reject(error)
          })
      })
    }
    return state.loadingPromise
  },
  fetchFeatured() {
    return this.fetchAll().then(books => books.filter(book => !!book.featured))
  },
  fetchByCategory(id) {
    return this.fetchAll().then(books =>
      books.filter(({ category_id }) => category_id == id)
    )
  },
  checkout() {
    return wait(true, 1500)
  }
}
