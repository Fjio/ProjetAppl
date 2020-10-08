# What are we going to do next ?

## Registration
- [x] register page
- [x] unicity exception management (email adress)
- [x] flushing data in database 
- [x] register success page render
## Verification
- [x] change user's database to include a "verified mail" token\
added, for now, a "creationDate (type Date)", a "validatedUser (type bool)", a "token (type string)"
- [x] token generation for verification (& email validation in the future)
- [x] see how to use the mailer !
- [ ] correct the mailer so as to use the real emails (passing parameters)
- [ ] send an url of verification with embedded token
- [ ] force users to verify before editing their data...
- [ ] add an autodeletion of non-verified users after ? one week ? this means implementing an registering date too (done)

## Improvements
- [ ] check how eleves is supposed to render as it is not finished yet
- [ ] improve mobile users' UI
- [x] fix favicon management
- [x] patch javascript datatable misuses
- [x] patch graphic glitches due to bootstrap misuse
- [x] add a navbar
- [x] modify the navbar depending on the fact the user is logged or not
- [x] patch the fact logged users could still reach login page (through redirection to homepage)

## Background processes
- [ ] weekly "Rapports d'avancement" not to forget each Friday
- [x] define what to show in the "Cahier des charges" for the 02/10
- [ ] define what to show in "Documentation" to deliver for the 16/10
- [ ] and mostly have fun 😁

## Do not forget announced specs
- [ ] Create a registration page with coherence due to existing pages
- [ ] Manage registrations with the database
- [ ] Manage verification email sending
- [ ] Manage robots attacks on the register page
- [ ] Correct the former group code
- [ ] Documentation due for the 16/10
- [ ] Project report skeleton due for the 04/12
- [ ] Final report due for the 05/01
- [ ] Final oral exam due for the 08/01