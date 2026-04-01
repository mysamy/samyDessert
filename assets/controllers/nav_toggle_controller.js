import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['menu', 'iconOpen', 'iconClose']

  connect() {
    this.isOpen = false
    this._pendingClose = null
    this.iconOpenTarget.style.display = ''
    this.iconCloseTarget.style.display = 'none'
    this.onResize = () => {
      if (window.innerWidth >= 1024 && this.isOpen) this.close()
    }
    this.onKeydown = (e) => {
      if (e.key === 'Escape' && this.isOpen) this.close()
    }
    window.addEventListener('resize', this.onResize)
    window.addEventListener('keydown', this.onKeydown)
  }

  disconnect() {
    window.removeEventListener('resize', this.onResize)
    window.removeEventListener('keydown', this.onKeydown)
  }

  toggle() {
    this.isOpen ? this.close() : this.open()
  }

  open() {
    this.isOpen = true
    if (this._pendingClose) {
      this.menuTarget.removeEventListener('animationend', this._pendingClose)
      this._pendingClose = null
    }
    this.menuTarget.show()
    this.menuTarget.classList.remove('nav__menu--leave')
    this.menuTarget.classList.add('nav__menu--enter')
    this.iconOpenTarget.style.display = 'none'
    this.iconCloseTarget.style.display = ''
  }

  close() {
    this.isOpen = false
    this.menuTarget.classList.remove('nav__menu--enter')
    this.menuTarget.classList.add('nav__menu--leave')
    this._pendingClose = () => {
      this.menuTarget.close()
      this.menuTarget.classList.remove('nav__menu--leave')
      this._pendingClose = null
    }
    this.menuTarget.addEventListener('animationend', this._pendingClose, { once: true })
    this.iconOpenTarget.style.display = ''
    this.iconCloseTarget.style.display = 'none'
  }
}
