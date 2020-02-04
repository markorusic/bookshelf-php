import { CURRENCY } from './config'
import { View } from '../../shared/utils'

const views = {
  cartBookView: new View(
    ({ id, name, main_photo, price, quantity }) => `
        <tr data-book-id="${id}">
            <td data-th="Book">
                <div class="row">
                    <div class="col-sm-4 hidden-xs">
                        <div class="card-book-img"
                            style="background-image: url('${main_photo}');"></div>
                    </div>
                    <div class="col-sm-8 d-flex align-items-center">
                    
                        <h4>${name}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Price">${price} ${CURRENCY}</td>
            
            <td data-th="Quantity">
                <input value="${quantity}" class="change-item-quantity input-number" type="number" step="1" min="1" name="quantity">
            </td>
            <td data-th="Total">
                <span class="single-item-total">
                    ${price * quantity}
                </span> ${CURRENCY}
            </td>
            <td class="actions" data-th="Remove">
                <button class="remove-from-cart btn btn-sm">
                    <img src="public/img/x.svg" alt="Remove from cart">
                </button>
            </td>
        </tr>
    `
  ),
  cartBooksTableView: new View(
    ({ cols = ['Book', 'Price', 'Quantity', 'Total', '&nbsp;'] }) => `
        <div class="col-md-8">
            <h6>Selected books (<span class="cart-items-count"></span>)</h6>
            <hr>
            <div class="table-responsive">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        ${cols.map(col => `<th>${col}</th>`).join('')}
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    `
  ),
  cartInfoView: new View(
    ({ currency, isLoggedIn }) => `
       <div class="col-md-4 info-box">
            ${
              isLoggedIn
                ? `
                <h6>Total</h6>
                <hr>
                <p class="d-flex flex-column justify-content-md-between flex-md-row">
                    <span>Total value of the books</span>
                    <span><span class="cart-items-total"></span> ${currency}</span>
                </p>

                <p class="d-flex flex-column justify-content-md-between flex-md-row font-weight-bold mt-3 mb-5">
                    <span>Total</span>
                    <span><span class="cart-items-total-with-shipping"></span> ${currency}</span>
                </p>
                <button
                    class="btn-add-to-cart-look d-flex justify-content-between"
                    data-toggle="modal"
                    data-target="#orderModal"
                >
                    <span>Continue</span>
                    <span class="btn-add-to-cart-plus"><img src="public/img/check.svg" alt="Add to cart"></span>
                </button>
            `
                : `
                <h6><a href="/login">Login</a> in order to complete the order.</h6>
                <hr>
                `
            }
            
        </div>
        `
  ),
  emptyCartView: new View(
    ({
      title = 'Your cart is currently empty.',
      message = 'You did not insert the book into your cart.',
      backButtonTitle = 'Back to shop'
    }) => `
        <div class="col-12 col-md-6 offset-md-3">
            <div class="flex-center-col pt-4">
                <h3 class="uc font-size-21 text-center">${title}</h3>
                <p class="small-p">${message}</p>
                <a href="/categories" class="uc btn btn-brand">
                    ${backButtonTitle}
                </a>
            </div>
        </div>
    `
  ),
  loaderView: new View(
    () => `
        <div class="cart-loader-wrapper">
            <div class="lds-ripple"><div></div><div></div></div>
        </div>
    `
  ),
  successfulCheckoutView: new View(
    ({ title = 'Thank you for purchasing our books!', message = '' }) => `
        <div class="flex-center-col" style="height: 100%; width: 100%;">
            <h3 class="uc font-size-21 text-center">${title}</h3>
            <p class="text-center">${message}</p>
        </div>
    `
  )
}

export default {
  $cartRoot: $('#cart-wrapper .row'),
  ...views,
  renderEmptyCart() {
    this.emptyCartView.render({}, this.$cartRoot)
  },
  renderLoader() {
    this.loaderView.render({}, this.$cartRoot)
  },
  initialRender(cart) {
    if (cart.length === 0) {
      this.renderEmptyCart()
      return false
    }
    const isLoggedIn = !!$('#auth-dropdown').length
    this.cartInfoView.render({ currency: CURRENCY, isLoggedIn }, this.$cartRoot)
    this.cartBooksTableView.render({}, this.$cartRoot, 'prepend')
    this.cartBookView.renderList(cart, '#cart tbody')
    return true
  }
}
