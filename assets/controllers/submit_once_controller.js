import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['btn', 'label', 'spinner']

  submit() {
    if (this.hasBtnTarget) {
      this.btnTarget.disabled = true
      this.btnTarget.setAttribute('aria-busy', 'true')
    }
    if (this.hasLabelTarget) {
      const loadingLabel = this.hasBtnTarget
        ? this.btnTarget.dataset.submitOnceLoadingLabel
        : this.element.dataset.submitOnceLoadingLabel
      if (loadingLabel) {
        this.labelTarget.textContent = loadingLabel
      } else {
        this.labelTarget.classList.add('invisible')
      }
    }
    if (this.hasSpinnerTarget) this.spinnerTarget.classList.remove('hidden')
  }
}