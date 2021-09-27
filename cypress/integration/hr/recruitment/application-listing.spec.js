describe("Recruitment", () => {
    it("opens up the job page", () => {
        const username = Cypress.env("username");
        const password = Cypress.env("password");
        cy.visit("/login");
        cy.get('[name="email"]').type(username);
        cy.get('[name="password"]').type(password);
        cy.get('[type="submit"]')
            .first()
            .click();
        cy.get("h3")
        .first()
        .should("have.text", "Dashboard");
        cy.visit("/hr/recruitment/job");
        cy.get(':nth-child(1) > .w-25p');
        cy.get(':nth-child(3) > .w-25p > :nth-child(1) > a.mr-1').click();
        let interviewScheduleUrl = null;
        cy.get('.btn-clipboard').invoke('attr', 'data-clipboard-text').then(link => {
            cy.log('link', link);
            interviewScheduleUrl = link;
            cy.log('interviewScheduleUrl', interviewScheduleUrl);
            if (interviewScheduleUrl) {
                cy.visit(interviewScheduleUrl);
                cy.get(':nth-child(5) > .fc-day-tue > .fc-daygrid-day-frame > .fc-daygrid-day-events > :nth-child(1) > .fc-daygrid-event').click();
                cy.get('.form-control').type("gautam@example.co.in");
                cy.get('#selectAppointmentSlotButton').click();
            }
        });
    });
});
  