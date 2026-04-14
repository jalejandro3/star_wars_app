# Star Wars App — PHP Technical Assessment
 
A PHP web application built as a technical interview challenge, consuming the public [SWAPI](https://swapi.dev) API to display Star Wars films and characters.
 
## What this project demonstrates
 
- Interface-based design with dependency injection — all services and clients are defined as contracts, not concrete implementations
- Separation of concerns — HTTP client, business logic, and presentation are clearly decoupled
- Event-driven behavior — user login triggers a domain event handled by a dedicated listener, keeping concerns separate
- Application of SOLID, DRY, and KISS principles throughout the codebase
 
## Tech stack
 
PHP 7.4, Symfony, Twig 3, MySQL
 
## Architecture decisions
 
The app follows a layered approach: a `StarWarsClient` handles all external API communication behind an interface, `CharacterService` and `FilmService` contain business logic independently of the HTTP layer, and a `MailService` is triggered via an event/listener pattern rather than being called directly — keeping the login flow clean and extensible.
 
