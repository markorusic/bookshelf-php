import { CURRENCY } from '../cart/config'
import View from '../../shared/View'

const limit = (str = '', chars = 28) =>
  `${str.slice(0, chars).trim()}${str.length >= chars ? '...' : ''}`

export default new View(
  ({ id, name, price, main_photo, category, page_count }, index) => `
    <div
      class="col-6 col-md-4 col-lg-3"
      data-pageable
      data-book-id="${id}"
      data-price="${price}"
      data-page_count="${page_count}"
      style="display:${index > 7 ? 'none' : 'block'};"
    >
      <article class="book-preview-article">
          <div class="book-image-preview position-relative">
              <a href="/book?id=${id}">
                <div class="book-list-item" style="background-image: url(${main_photo})"></div>
              </a>
              <button data-book-id="${id}" class="btn-add-to-cart d-flex justify-content-between preview-book-atc">
                <span>Add to cart</span>
                <span class="btn-add-to-cart-plus"><img src="/public/img/plus.svg" alt="Add to cart"></span>
              </button>
          </div>
          <div class="d-flex flex-column justify-content-md-between flex-md-row">
              <h4><a href="/book?id=${id}">${limit(name)}</a></h4>
              <h4>${price} ${CURRENCY}</h4>
          </div>
          ${
            category
              ? `
          <h6 class="pb-1 d-flex justify-content-between">
            <a style="color: inherit;" href="/category?id=${category.id}">
              ${category.name}
            </a>
            <span>Page count: ${page_count}</span>
          </h6>
      `
              : ''
          }
      </article>
    </div>
  `
)
