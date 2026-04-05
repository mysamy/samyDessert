import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['dialog']

  open() {
    this.dialogTarget.showModal()
  }

  close() {
    this.dialogTarget.close()
  }

  closeOnBackdrop(e) {
    if (e.target === this.dialogTarget) {
      this.dialogTarget.close()
    }
  }
}
