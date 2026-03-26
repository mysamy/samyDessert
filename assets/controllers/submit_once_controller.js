import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['btn', 'label', 'spinner']

  submit() {
    const fieldset = this.element.querySelector('fieldset')
    if (fieldset) fieldset.disabled = true

    if (this.hasBtnTarget) {
      this.btnTarget.disabled = true
      this.btnTarget.setAttribute('aria-busy', 'true')
    }
    if (this.hasLabelTarget) this.labelTarget.classList.add('hidden')
    if (this.hasSpinnerTarget) this.spinnerTarget.classList.remove('hidden')
  }
}