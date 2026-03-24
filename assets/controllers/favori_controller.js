// Stimulus controller pour le toggle favori (coeur) sur les DessertCard
// Envoie un POST AJAX à l'URL du toggle, met à jour l'icône sans rechargement
// Délègue l'affichage du message "connectez-vous" au controller flash-tooltip
import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static values = { url: String, active: Boolean }
  static targets = ['icon', 'btn']
  static outlets = ['flash-tooltip']

  async toggle() {
    try {
      const response = await fetch(this.urlValue, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
      })

      // Non connecté → délègue au flash-tooltip
      if (response.status === 401) {
        if (this.hasFlashTooltipOutlet) {
          this.flashTooltipOutlet.show()
        }
        return
      }

      if (!response.ok) return

      const data = await response.json()
      this.activeValue = data.favori
    } catch (e) {
      // Échec silencieux (pas de réseau, etc.)
    }
  }

  // Appelé automatiquement par Stimulus quand activeValue change
  activeValueChanged() {
    const icon = this.iconTarget
    const btn = this.btnTarget

    if (this.activeValue) {
      icon.classList.replace('fa-regular', 'fa-solid')
      btn.classList.remove('text-gray-light', 'hover:text-accent')
      btn.classList.add('text-accent')
      btn.setAttribute('aria-label', 'Retirer des favoris')
    } else {
      icon.classList.replace('fa-solid', 'fa-regular')
      btn.classList.remove('text-accent')
      btn.classList.add('text-gray-light', 'hover:text-accent')
      btn.setAttribute('aria-label', 'Ajouter aux favoris')
    }
  }
}
