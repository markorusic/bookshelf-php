Dropzone.autoDiscover = false

document.addEventListener('DOMContentLoaded', () => {
  formModule.init()
})

const formModule = (() => {
  $('form .delete-gallery-item').on('click', _handleGalleryPhotoDelete)

  function _handleGalleryPhotoDelete(event) {
    event.preventDefault()
    const $element = $(event.target)
    const endpoint = $element.data().endpoint
    if (!endpoint || !confirm('Are you sure?')) {
      return
    }
    axios
      .delete(endpoint)
      .then(() => {
        $element
          .parent()
          .parent()
          .fadeOut(() => {
            $element.remove()
          })
      })
      .catch(error => {
        alert('Error occured while deleting gallery photo!')
        console.log(error)
      })
  }

  const textEditorModule = {
    init() {
      const $summernote = $('.summernote')
      $summernote.removeClass('hidden').summernote({
        height: 400,
        popover: {
          image: [],
          link: [],
          air: []
        }
      })
    }
  }

  const photoUploadModule = (() => {
    const maxFilesize = 2 // MB
    const url = window.location.origin + '/admin/upload/photo'
    const previewTemplate = `
      <div class="preview hidden">
        <img class="hidden img-fluid" data-dz-thumbnail />
        <div>
          <div class="hidden"><span data-dz-name></span></div>
          <div class="hidden" data-dz-size></div>
        </div>
        <div class="hidden"><span data-dz-uploadprogress></span></div>
        <div class="hidden"><span>✔</span></div>
        <div class="hidden"><span>✘</span></div>
        <div class="hidden"><span data-dz-errormessage></span></div>
      </div>
    `

    const $dom = {}

    function _cacheDom() {
      $dom.preview = $('.my-preview')
      $dom.zones = $('.dz')
      $dom.zoneGalleries = $('.dz-gallery')
    }

    function _bindEvent() {
      $dom.preview.on('click', event => {
        $(event.target)
          .parent()
          .trigger('click')
      })
    }

    function _initZones() {
      _initPhotoFields()
      _initGalleryFields()
    }

    function _initPhotoFields() {
      $dom.zones.each((index, dzElement) => {
        const selector = '#' + $(dzElement).attr('id')
        new Dropzone(selector, {
          url,
          previewTemplate,
          maxFilesize,
          init() {
            const $zone = $(selector)
            this.on('sending', function() {
              $zone.find('span.text').text('')
            })
            this.on('success', function(file, response) {
              $zone.find('.my-preview img').attr('src', response.photo)
              $zone.prev().val(response.photo)
            })
            this.on('error', function() {
              this.removeAllFiles(true)
              $zone.find('span.text').text('Error while uploading photo!')
            })
          }
        })
      })
    }

    function _initGalleryFields() {
      $dom.zoneGalleries.each((index, dzElement) => {
        const selector = '#' + $(dzElement).attr('id')
        new Dropzone(selector, {
          url,
          maxFilesize,
          init() {
            const $gallery = $(selector)
            const inputName = $gallery.data().name
            this.on('success', function(file, response) {
              $gallery.append(`
                  <input type="hidden" name="${inputName}" value="${response.photo}">
                `)
            })
          }
        })
      })
    }

    return {
      init() {
        _cacheDom()
        _bindEvent()
        _initZones()
      }
    }
  })()

  const formSubmitionModule = (() => {
    function _handleFormSubmit(event) {
      event.preventDefault()
      const $form = $(event.target)
      const formData = _collectData($form)
      const validation = _validateData(formData.data)
      if (!validation.value) {
        return alert(validation.error)
      }
      $form.find('button[type="submit"]').addClass('loading-btn')
      _sendRequest(formData)
        .then(
          responseHandlers.success.bind(
            responseHandlers,
            $form,
            formData.config
          )
        )
        .catch(
          responseHandlers.error.bind(responseHandlers, $form, formData.config)
        )
    }

    function _sendRequest({ config, data }) {
      const { method, endpoint } = config
      return axios[method](endpoint, data)
    }

    function _collectData($form) {
      return {
        config: $form.find('.config').data(),
        data: $form.serializeJSON({
          checkboxUncheckedValue: 'false',
          parseBooleans: true,
          parseNumbers: true
        })
      }
    }

    function _validateData(data) {
      // all main_photo are requried by default
      const isValid = !(data.hasOwnProperty('main_photo') && !data.main_photo)
      return {
        value: isValid,
        error: 'Main photo is required!'
      }
    }

    const responseHandlers = {
      success($form, config) {
        const $msg = $form.find('.error-message')
        $msg
          .parent()
          .parent()
          .addClass('hidden')
        $msg.html('')
        switch (config.method) {
          case 'post':
            return this.successCreate($form, config)
          case 'put':
            return this.successUpdate($form, config)
          default:
            break
        }
      },
      error($form, config, error) {
        const data = error.response.data
        console.log(data)

        $.toast({
          heading: 'Error',
          text: 'Error occured during this action!',
          showHideTransition: 'slide',
          icon: 'error',
          position: 'top-right',
          loader: false
        })

        $form.find('button[type="submit"]').removeClass('loading-btn')
      },
      successCreate($form) {
        $.toast({
          heading: 'Success',
          text: 'Successfuly created!',
          showHideTransition: 'slide',
          icon: 'success',
          position: 'top-right',
          loader: false
        })

        $form
          .on('submit', event => event.preventDefault())
          .find('button[type="submit"]')
          .fadeOut()
      },
      successUpdate($form) {
        $.toast({
          heading: 'Success',
          text: 'Successfuly updated!',
          showHideTransition: 'slide',
          icon: 'success',
          position: 'top-right',
          loader: false
        })
        // clear gallery fields
        $('.dz-gallery')
          .find('input[type="hidden"]')
          .remove()
        $form
          .on('submit', event => event.preventDefault())
          .find('button[type="submit"]')
          .removeClass('loading-btn')
      }
    }

    return {
      init() {
        $('[data-ajax-form]').on('submit', _handleFormSubmit)
      }
    }
  })()

  return {
    init() {
      textEditorModule.init()
      photoUploadModule.init()
      formSubmitionModule.init()
    }
  }
})()
