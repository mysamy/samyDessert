import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  connect() {
    if (!this.hasConsent()) {
      this.element.show()
    }
  }

  accept() {
    this.setConsent('accepted')
    this.element.close()
  }

  reject() {
    this.setConsent('rejected')
    this.element.close()
  }

  hasConsent() {
    return document.cookie.split('; ').some(c => c.startsWith('cookie_consent='))
  }

  setConsent(value) {
    const expires = new Date()
    expires.setFullYear(expires.getFullYear() + 1)
    document.cookie = `cookie_consent=${value}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`
  }
}
