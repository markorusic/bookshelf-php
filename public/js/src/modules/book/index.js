import bookOrdering from './ordering'
import bookView from './view'

export default {
  view: bookView,
  init({ featuredBooks, categoryBooks }) {
    bookView.renderList(featuredBooks.slice(0, 4), '#home-book-group-1 .row')
    bookView.renderList(featuredBooks.slice(4, 8), '#home-book-group-2 .row')
    bookView.renderList(categoryBooks, '#book-list')
    bookOrdering.init()
  }
}
