describe('HQRentalsVehicleTypesGrid Shortcode Test', () => {
    beforeEach(() => {
        cy.visit('/');
    });
    it('should render shortcode', () => {
        cy.getCy('hq-smart-vehicle-grid').should('exist');
        cy.getCy('hq-vehicle-grid-with-types').should('exist');
    });
    it('should filter by vehicle types', () => {
        cy.fixture('vehicle-types.json').then((vehiclesTypes) => {
            vehiclesTypes.forEach((type) => {
                cy.getCy('trigger-' + type.id).click();
                cy.getCy(type.id).should('be.visible');
                vehiclesTypes.forEach(typeInner => {
                    if(typeInner.id != type.id){
                        cy.getCy(typeInner.id).should('not.visible');
                    }
                });
            })
        });
    });
})