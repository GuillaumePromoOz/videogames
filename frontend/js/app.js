let app = {
    init: function() {
        console.log('app.init()');

        // On appelle la méthode s'occupant d'ajouter les EventListener sur les éléments déjà dans le DOM
        app.addAllEventListeners();

        // On appelle la méthode s'occupant de charger tous les jeux vidéo
        app.loadVideoGames();

        app.loadPlatforms();
    },
    addAllEventListeners: function() {

        //---- VIDEOGAME SELECT ----//

        // On récupère l'élément <select> des jeux vidéo
        let select = document.getElementById('videogameId');
        //console.log(select);
        
        // On ajoute l'écouteur pour l'event "change", et on l'attache à la méthode app.handleVideogameSelected
        select.addEventListener('change', app.handleVideogameSelected);

        //---- ADD VIDEOGAME BUTTON ----//

        // On récupère le bouton pour ajouter un jeu vidéo
        let addVideogameButtonElement = document.getElementById('btnAddVideogame');
        // On ajoute l'écouteur pour l'event "click"
        addVideogameButtonElement.addEventListener('click', app.handleClickToAddVideogame);
        
        //---- ADD REVIEW BUTTON ----//

        let addReviewButtonElement = document.getElementById('btnAddReview');
        addReviewButtonElement.addEventListener('click', app.handleClickToAddReview);

        //---- FORM SUBMISSION ----//

        //ciblage du modal videogame

        let addVideogameModalElement = document.getElementById('addVideogameForm');
        addVideogameModalElement.addEventListener('submit', app.handleSubmitForm);

        //ciblage du modal review

        let addReviewModalElement = document.getElementById('addReviewForm');
        addReviewModalElement.addEventListener('submit', app.handleReviewSubmitForm);


    },

    handleVideogameSelected: function(evt) {

        // Récupérer la valeur du <select> (id du videogame)
        let select = evt.currentTarget;

        //je récupère l'input de select
        let id = select.value;
        //console.log(select);

        // Vider le contenu de div#review (pour qu'au rechargement de la page, la div se vide à chaque fois que l'on selectionne un nouveau jeu
        // et ainsi le nouveau template s'affiche à la place du précendent template)
        document.getElementById('review').textContent = "";

        // charger les données pour ce videogame

        let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        }

        //je renseigne le bon endpoint, à savoir la route GET qui récupère pas seulement les videogames mais aussi son id ET les reviews
        // dans insomnia : http://localhost:8080/videogames/3/reviews

        let url = 'http://localhost/Perso/videogames/backend/public/videogames/' + id + '/reviews';

        let request = fetch(url, fetchOptions);

        request.then(function(responseJSON) {
            return responseJSON.json();
        }).then(function(reviews) {
            console.log(reviews);


            for(let review of reviews) {
                // Dupliquer la template #reviewTemplate et personnaliser son contenu avec les données
                let template = document.getElementById('reviewTemplate').content.cloneNode(true);

                //je récupère dans ma template (template.) le nom de la class dans chaque balise HTML (ex, .reviewTitle)
                //je lui rajoute du textContent dans lequel j'injecte le contenue via...
                //... l'index (review, qui parcours le tableau reviews) et le champs dans le tableau dans la console (title, text, author, publication_date, etc)
                template.querySelector('.reviewTitle').textContent=review.title;
                template.querySelector('.reviewText').textContent=review.content;
                template.querySelector('.reviewAuthor').textContent=review.author;
                template.querySelector('.reviewPublication').textContent=review.publicationDate;
                template.querySelector('.reviewDisplay').textContent=review.displayRating;
                template.querySelector('.reviewGameplay').textContent=review.gameplayRating;
                template.querySelector('.reviewScenario').textContent=review.storyRating;
                template.querySelector('.reviewLifetime').textContent=review.lifetimeRating;
                template.querySelector('.reviewVideogame').textContent=review.videogame.name;
                template.querySelector('.reviewEditor').textContent=review.videogame.editor;
                template.querySelector('.reviewPlatform').textContent=review.videogame.platform.name;

                //j'ajoute le template dans le dom : je cible la div avec l'id "review"
                //et je lui injecte via la fonction appendChild le template dans la div qui a pour class "reviewContainer"
                //j'ai essayé de lui injecter le template directement via "reviewTemplate" mais ça ne fonctionne pas
                //dans la correction de Julien il cible la div juste en dessous du template mais je ne comprend pas pourquoi
                document.getElementById('review').appendChild(template.querySelector('.reviewContainer'));
            }
        });
        
    },

    handleClickToAddVideogame: function() {
        // https://getbootstrap.com/docs/4.4/components/modal/#modalshow
        // jQuery obligatoire ici
        $('#addVideogameModal').modal('show');
    },

     handleClickToAddReview: function() {
        // https://getbootstrap.com/docs/4.4/components/modal/#modalshow
        // jQuery obligatoire ici
        $('#addReviewModal').modal('show');
    },

    //la fonction handleSubmitForm va nous permettre d'ajouter un nouveau jeu dans la bdd

     handleReviewSubmitForm: function() {
        //alert('handle form ok!!')

        //recuperation de l'input Name
        let newReviewTitleElement = document.getElementById('inputTitle');
        //recuperation de valeur saisie par l'utilisateur dans l'input
        let newReviewTitle = newReviewTitleElement.value;

        let newReviewContentElement = document.getElementById('inputContent');
        let newReviewContent = newReviewContentElement.value;

        let newReviewAuthorElement = document.getElementById('inputAuthor');
        let newReviewAuthor = newReviewAuthorElement.value;

        let newReviewDisplayElement = document.getElementById('inputDisplay');
        let newReviewDisplay = newReviewDisplayElement.value;

        let newReviewGameplayElement = document.getElementById('inputGameplay');
        let newReviewGameplay = newReviewGameplayElement.value;
    
        let newReviewStoryElement = document.getElementById('inputStory');
        let newReviewStory = newReviewStoryElement.value;

        let newReviewLifetimeElement = document.getElementById('inputLifetime');
        let newReviewLifetime = newReviewLifetimeElement.value;
     
        // Récupérer la valeur du <select> (id du videogame)
        let videogameToReviewSelect = document.getElementById('inputVideogameToReview');

        //je récupère l'input de select
        let videogameId = videogameToReviewSelect.value;
        console.log(videogameId);

        //appel à l'API

        let data = {
            'title': newReviewTitle,
            'content': newReviewContent,
            'author': newReviewAuthor,
            'display_rating': newReviewDisplay,
            'gameplay_rating': newReviewGameplay,
            'story_rating': newReviewStory,
            'lifetime_rating': newReviewLifetime,
            'videogame': videogameId,
        };

        // On prépare les entêtes HTTP (headers) de la requête
        // afin de spécifier que les données sont en JSON
        let myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        // On consomme l'API pour ajouter en DB
        let fetchOptions = {
        method: 'POST',
        // On ajoute les headers dans les options
        headers: myHeaders,
        // On ajoute les données, encodée en JSON, dans le corps de la requête
        body: JSON.stringify(data)
    };

    const url = 'http://localhost/Perso/videogames/backend/public/reviews';
    fetch(url, fetchOptions)
      .then(function(response) {  // la réponse été récupérée, on l'interprête en tant que json
        return response.json();
      })   
        
    },

    // Method handleReviewSubmitForm allows us to add a new review to any game

    handleSubmitForm: function() {
        //alert('handle form ok!!')

        //recuperation de l'input Name
        let newGameNameElement = document.getElementById('inputName');
        //recuperation de valeur saisie par l'utilisateur dans l'input
        let newGameName = newGameNameElement.value;
        console.log(newGameName);

        let newGameEditorElement = document.getElementById('inputEditor');
        let newGameEditor = newGameEditorElement.value;
        console.log(newGameEditor);

        // Récupérer la valeur du <select> (id du videogame)
        let platformSelect = document.getElementById('inputPlatform');

        //je récupère l'input de select
        let platformId = platformSelect.value;
        console.log(platformId);

        //appel à l'API

        let data = {
            'name': newGameName,
            'editor': newGameEditor,
            'platform': platformId,
        };

        // On prépare les entêtes HTTP (headers) de la requête
        // afin de spécifier que les données sont en JSON
        let myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        // On consomme l'API pour ajouter en DB
        let fetchOptions = {
        method: 'POST',
        // On ajoute les headers dans les options
        headers: myHeaders,
        // On ajoute les données, encodée en JSON, dans le corps de la requête
        body: JSON.stringify(data)
    };

    const url = 'http://localhost/Perso/videogames/backend/public/videogames';
    fetch(url, fetchOptions)
      .then(function(response) {  // la réponse été récupérée, on l'interprête en tant que json
        return response.json();
      })   
        
    },

    loadVideoGames: function() {
          
        // Charger toutes les données des videogames
         let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        }

        let url = 'http://localhost/Perso/videogames/backend/public/videogames';

        let request = fetch(url, fetchOptions);

        request.then(function(responseJSON) {
            console.log(responseJSON);
            return responseJSON.json();
        }).then(function(videogames) {
            //console.log(videogames);

            // nous enregistrons les jeux video dans un tableau associatif.
            // l'id des catégories servira d'index
            
            let videogamesListing = {};
             
            // pour chaque jeux ; nous allons ajouter une option dans le select
            
            for(let videogame of videogames) {
                //voir commentaire plus haut sur tableaux asso
                let videogameId = videogame.id;
                videogamesListing[videogameId] = videogame;

                 //-- VIDEOGAME LIST FOR SELECT --//

                //nous ciblons le select dans le DOM
                let videogameListSelectElement = document.getElementById('videogameId');
                //on crée un élément option
                let videogameListOptionElement = document.createElement('option');
                //console.log(optionElement);
                //on "customize" l'élément option
                videogameListOptionElement.textContent = videogame.name; //le contenu texte de l'option
                videogameListOptionElement.setAttribute('value', videogame.id);
                

                //on injecte l'option dans le select
                videogameListSelectElement.appendChild(videogameListOptionElement);

                //-- VIDEOGAME LIST FOR ADD REVIEW MODAL --//

                //nous ciblons le select dans le DOM
                let videogameToReviewselectElement = document.getElementById('inputVideogameToReview');
                //on crée un élément option
                let videogameToReviewOptionElement = document.createElement('option');
                //console.log(optionElement);
                //on "customize" l'élément option
                videogameToReviewOptionElement.textContent = videogame.name; //le contenu texte de l'option
                videogameToReviewOptionElement.setAttribute('value', videogame.id);
                

                //on injecte l'option dans le select
                videogameToReviewselectElement.appendChild(videogameToReviewOptionElement);

            }

        });
            
    },

    loadPlatforms: function() {
        // Charger toutes les données des platforms
         let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        }

        let url = 'http://localhost/Perso/videogames/backend/public/platforms';

        let request = fetch(url, fetchOptions);

        request.then(function(responseJSON) {
            console.log(responseJSON);
            return responseJSON.json();
        }).then(function(platforms) {
            //console.log(platforms);

            // nous enregistrons les platforms dans un tableau associatif.
            // l'id des catégories servira d'index
            
            let platformsListing = {};
             
            // pour chaque platform ; nous allons ajouter une option dans le select
            
            for(let platform of platforms) {
                //voir commentaire plus haut sur tableaux asso
                let platformId = platform.id;
                platformsListing[platformId] = platform;

                //nous ciblons le select dans le DOM
                let selectElement = document.getElementById('inputPlatform');
                //on crée un élément option
                let optionElement = document.createElement('option');
                //console.log(optionElement);
                //on "customize" l'élément option
                optionElement.textContent = platform.name; //le contenu texte de l'option
                optionElement.setAttribute('value', platform.id);
                

                //on injecte l'option dans le select
                selectElement.appendChild(optionElement);

            }

        });
            
    },
};

document.addEventListener('DOMContentLoaded', app.init);