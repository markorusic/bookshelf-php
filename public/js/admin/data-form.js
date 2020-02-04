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
      success($form, config, response) {
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
        const errorMessage = data.errors
          ? Object.values(data.errors).join('<br />')
          : 'Error occured.'
        const $msg = $form.find('.error-message')
        $msg
          .parent()
          .parent()
          .removeClass('hidden')
        $msg.html(errorMessage)
        $form.find('button[type="submit"]').removeClass('loading-btn')
      },
      successCreate($form, { resource }) {
        const $alert = $form.find('.response-alert').addClass('p-3')
        let createUrl = location.href
        let seeAllUrl = ''
        let seeAllHTML = ''

        if (resource) {
          createUrl = `${location.origin}/admin/${resource}/create`
          seeAllUrl = `${location.origin}/admin/${resource}/showAll`
          seeAllHTML = `<li><a class="bold" href="${seeAllUrl}">See all</a></li>`
        }

        const linksHTML = `
          <ul class="flex-list nice-list">
            <li><a class="bold" href="${createUrl}">Create new</a></li>
            ${seeAllHTML}
          </ul>
        `

        $alert.find('.message').text('Successfuly created!')
        $alert.find('.options').html(linksHTML)

        $form
          .on('submit', event => event.preventDefault())
          .find('button[type="submit"]')
          .fadeOut()
      },
      successUpdate($form, { resource }) {
        // clear gallery fields
        $('.dz-gallery')
          .find('input[type="hidden"]')
          .remove()

        const $alert = $form.find('.response-alert').addClass('p-3')
        const time = dayjs().format('HH:mm:ss')

        $alert.find('.message').text('Successfuly updated!')
        $alert.find('.options').text(`Updated at: ${time}`)

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
