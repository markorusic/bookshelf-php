import { FormValidation } from '../../shared/utils'
import bookService from '../book/book-service'
import store from './store'
import view from './view'
import { ACTIONS, SHIPPING_FEE, LC_CART_KEY } from './config'

const { CART_ITEMS_LOADING, CART_ITEMS_LOADED, CART_UPDATED } = ACTIONS

export default (() => {
  const isCartPage = window.location.pathname === '/cart'

  let checkoutFormValidator = null
  let checkoutInProgress = false
  const $dom = {}

  function _initCart() {
    store.eventBus.on(CART_ITEMS_LOADING, () => {
      if (isCartPage) {
        view.renderLoader()
      }
    })
    store.eventBus.on(CART_ITEMS_LOADED, cart => {
      if (isCartPage) {
        view.initialRender(cart)
        _cahceCartDom()
        checkoutFormValidator = new FormValidation({ $form: $dom.checkoutForm })
        _bindCartEvents()
      }
    })
    store.eventBus.on(CART_UPDATED, cart => {
      $dom.cartItemsCount.text(store.countItems())
      if (isCartPage) {
        if (cart.length === 0) {
          view.renderEmptyCart()
        }
        const total = parseFloat(store.total()).toFixed(2)
        const totalWithFee = parseFloat(total + SHIPPING_FEE).toFixed(2)
        $dom.cartTotal.text(total)
        $dom.cartTotalWithShipping.text(totalWithFee)
      }
    })
    store.initCart()
  }

  function _cacheDom() {
    $dom.addToCart = $('.btn-add-to-cart')
    $dom.addToCartQuantity = $('#add-to-cart-quantity')
    $dom.cartItemsCount = $('.cart-items-count')
  }

  function _cahceCartDom() {
    $dom.cartTotal = $('.cart-items-total')
    $dom.cartTotalWithShipping = $('.cart-items-total-with-shipping')
    $dom.removeFromCart = $('.remove-from-cart')
    $dom.changeQuantity = $('.change-item-quantity')
    $dom.cartItemsCount = $('.cart-items-count')
    $dom.checkoutForm = $('#checkout-form')
    $dom.orderModal = $('#orderModal')
  }

  function _bindEvents() {
    $dom.addToCart.on('click', _handleAddToCart)
  }

  function _bindCartEvents() {
    $dom.removeFromCart.on('click', _handleRemoveFromCart)
    $dom.changeQuantity.on('change keydown', _handleQuantityChange)
    $dom.checkoutForm.on('submit', _handleCheckout)
  }

  function _handleAddToCart(event) {
    event.preventDefault()
    const $btn = $(event.target).closest('[data-book-id]')
    const id = $btn.data().bookId
    let quantity = 1

    if (!id) {
      return
    }

    if ($dom.addToCartQuantity.length > 0) {
      quantity = parseInt($dom.addToCartQuantity.val())
    }

    store.add({ id, quantity })
    $.toaster('Successfully added to <a href="/cart">cart</a>!')
  }

  function _handleRemoveFromCart(event) {
    event.preventDefault()
    const $el = $(event.target)
    const $book = $el.closest('[data-book-id]')
    store.remove($book.data().bookId)
    $book.fadeOut()
  }

  function _handleQuantityChange(event) {
    event.preventDefault()
    const $el = $(event.target)
    const $book = $el.closest('[data-book-id]')
    const book = $book.data()
    const quantity = parseInt($el.val())
    if (isNaN(quantity)) {
      return
    }
    store.add(
      {
        id: book.bookId,
        quantity
      },
      false
    )
    $book.find('.single-item-total').text(store.totalByItem(book.bookId))
  }

  function _handleCheckout(event) {
    event.preventDefault()
    if (checkoutInProgress) {
      return
    }
    if (!checkoutFormValidator.validate()) {
      return
    }
    checkoutInProgress = true
    const $form = $(event.target)
    const $btn = $form.find('button[type="submit"]')
    const $modalBody = $form.parent()
    const btnTextBefore = $btn.text()
    $btn.css({ 'pointer-events': 'none' }).text('Please wait...')
    bookService
      .checkout()
      .then(() => {
        localStorage.removeItem(LC_CART_KEY)
        $form.fadeOut(() => {
          $modalBody.addClass('flex-center-col')
          view.successfulCheckoutView.render({}, $modalBody)
        })
        $dom.orderModal.on('hide.bs.modal', () => store.clear())
        checkoutInProgress = false
      })
      .catch(() => {
        checkoutInProgress = false
        $btn.css({ 'pointer-events': 'auto' }).text(btnTextBefore)
        alert('An error has occurred!')
      })
  }

  return {
    init() {
      _cacheDom()
      _initCart()
      _bindEvents()
    }
  }
})()
