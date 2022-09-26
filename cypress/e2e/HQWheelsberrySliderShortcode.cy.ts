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
        const selectedLocationId = '1';
        cy.getCy('hq-wheelsberry-slider-form-pick-up-location').select(selectedLocationId);
        cy.getCy('hq-wheelsberry-slider-form-return-location').invoke('val').should('deep.equal', selectedLocationId);
    });


})