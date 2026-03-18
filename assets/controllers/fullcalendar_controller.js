import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { eventsUrl: String };

    connect() {
        // FullCalendar est chargé via CDN (window.FullCalendar)
        if (typeof window.FullCalendar === 'undefined') {
            console.error('FullCalendar non chargé');
            return;
        }

        this.calendar = new window.FullCalendar.Calendar(this.element, {
            locale: 'fr',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth',
            },
            buttonText: {
                today: "Aujourd'hui",
                month: 'Mois',
                week: 'Semaine',
                list: 'Liste',
            },
            events: this.eventsUrlValue,
            eventClick: (info) => {
                const p = info.event.extendedProps;
                const statutLabel = {
                    en_attente: 'En attente',
                    confirmee: 'Confirmée',
                    livree: 'Livrée',
                    annulee: 'Annulée',
                };
                alert(
                    info.event.title
                    + '\nTotal : ' + parseFloat(p.total).toFixed(2) + ' €'
                    + '\nStatut : ' + (statutLabel[p.statut] ?? p.statut)
                );
            },
            height: 'auto',
        });

        this.calendar.render();
    }

    disconnect() {
        if (this.calendar) {
            this.calendar.destroy();
        }
    }
}
