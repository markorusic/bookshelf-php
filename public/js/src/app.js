import axios from 'axios'
import { FormValidation, formData, url, pagination } from './shared'
import { book, cart, category } from './modules'
import { CURRENCY } from './modules/cart/config'
import bookService from './modules/book/book-service'
import categoryService from './modules/category/categoryService'

const app = {
  load() {
    const id = url.getParam('id')
    return Promise.all([
      bookService.fetchFeatured(),
      bookService.fetchByCategory(id),
      categoryService.fetchAll()
    ])
  },
  initContactForm() {
    const $form = $('#contact-form')
    const validator = new FormValidation({ $form })
    $form.on('submit', event => {
      event.preventDefault()
      if (!validator.validate()) {
        return
      }
      const $btn = $form.find('button[type="submit"]')
      const $formWrapper = $form.parent()
      $btn.css({ 'pointer-events': 'none' }).text('Please wait...')
      axios
        .post('/api/contact', formData($form))
        .then(() => {
          $form.fadeOut(() => {
            $formWrapper.html(
              `<div><p class="font-size-21">Thank you. You have successfully sent a message. We'll answer soon.</p></div>`
            )
          })
        })
        .catch(err => {
          alert('Error')
          console.log(err)
        })
    })
  },
  initFileExports() {
    $('#export-aboutme').on('click', event => {
      event.preventDefault()
      const header =
        "<html xmlns:o='urn:schemas-microsoft-com:office:office' " +
        "xmlns:w='urn:schemas-microsoft-com:office:word' " +
        "xmlns='http://www.w3.org/TR/REC-html40'>" +
        "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>"
      const footer = '</body></html>'
      const sourceHTML =
        header + document.querySelector('.content-wrapper').innerHTML + footer

      const source =
        'data:application/vnd.ms-word;charset=utf-8,' +
        encodeURIComponent(sourceHTML)
      const fileDownload = document.createElement('a')
      document.body.appendChild(fileDownload)
      fileDownload.href = source
      fileDownload.download = 'about-me.docx'
      fileDownload.click()
      document.body.removeChild(fileDownload)
    })
  },
  showCurrency() {
    $('.currency').text(CURRENCY)
  },
  init() {
    FormValidation.init()
    app.initContactForm()
    app.initFileExports()
    app.load().then(([featuredBooks, categoryBooks, categories]) => {
      book.init({
        featuredBooks: mergeWithCategories(featuredBooks, categories),
        categoryBooks: mergeWithCategories(categoryBooks, categories)
      })
      category.init({ categories })
      cart.init()
      pagination.init()
      app.showCurrency()
    })
  }
}

const mergeWithCategories = (books, categories) =>
  books.map(book => {
    const category = categories.find(({ id }) => book.category_id === id)
    if (category) {
      book.category = category
    }
    return book
  })

export default app
