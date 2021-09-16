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
        cy.get('[class="btn btn-primary text-white"]').contains("Add new application").click(); 
        cy.get('[name="job_title"]').select(Cypress.env('job')); 
        cy.get('[name="first_name"]').type(Cypress.env('fname'));
        cy.get('[name="last_name"]').type(Cypress.env('lname'));
        cy.get('[name="email"]').type(Cypress.env('username'));
        cy.get('[name="resume_file"]').attachFile('SampleResume.pdf');
        cy.get('[type="submit"]').contains("Save").click();    
        cy.get("[name='search']").type(Cypress.env('username'));
        cy.get("button").contains("Search").click(); 
        cy.get("[class='mr-1 text-truncate']").contains(Cypress.env('username'));
    });
});
  