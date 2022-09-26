describe('HQWheelsberrySlider Shortcode Test', () => {
    beforeEach(() => {
        cy.visit('/homepage-hq/');
    });
    it('should render shortcode', () => {
        cy.getCy('hq-wheelsberry-slider').should('be.visible');
        cy.getCy('hq-wheelsberry-slider-form').should('be.visible');
    });
    it('when selecting pickup location, return location should change to the selected pickup location', () => {
        cy.getCy('hq-wheelsberry-slider-form-pick-up-location').should('be.visible');
        const selectedPickupLocationId = '1';
        cy.getCy('hq-wheelsberry-slider-form-pick-up-location').select(selectedPickupLocationId);
        cy.getCy('hq-wheelsberry-slider-form-return-location').invoke('val').should('deep.equal', selectedPickupLocationId);
    });
    it('when selecting pickup time, return time should change to the selected pickup time', () => {
        cy.getCy('hq-wheelsberry-slider-form-pick-up-time').should('be.visible');
        const times = [
            '12:00',
            '12:30',
            '01:00',
            '23:00',
            '23:15',
            '23:30',
            '23:45',
        ];
        times.forEach((time) => {
            cy.getCy('hq-wheelsberry-slider-form-pick-up-time').select(time);
            cy.getCy('hq-wheelsberry-slider-form-return-time').invoke('val').should('deep.equal', time);
        });

    });
})