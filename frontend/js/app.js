let app = {
    init: function() {
        console.log('app.init()');

        // Initializes method that adds all event listeners
        app.addAllEventListeners();

        // Initializes method that loads all videogames
        app.loadVideoGames();

        // Initializes method that loads all platforms
        app.loadPlatforms();
    },
    addAllEventListeners: function() {

        //---- VIDEOGAME SELECT ----//

        // Fetches the <select> element of the videogames' list
        let select = document.getElementById('videogameId');
        
        // Adds the listener to the event "change" + ties it to the according handler
        select.addEventListener('change', app.handleVideogameSelected);

        //---- ADD VIDEOGAME BUTTON ----//

        // Fetches the "add videogame" button element
        let addVideogameButtonElement = document.getElementById('btnAddVideogame');
        // Add listener to event "click" + ties it to according handler
        addVideogameButtonElement.addEventListener('click', app.handleClickToAddVideogame);
        
        //---- ADD REVIEW BUTTON ----//

        let addReviewButtonElement = document.getElementById('btnAddReview');
        addReviewButtonElement.addEventListener('click', app.handleClickToAddReview);

        //---- FORM SUBMISSION ----//

        // Targets videogame Modal

        let addVideogameModalElement = document.getElementById('addVideogameForm');
        addVideogameModalElement.addEventListener('submit', app.handleVideogameSubmitForm);

        // Targets review Modal

        let addReviewModalElement = document.getElementById('addReviewForm');
        addReviewModalElement.addEventListener('submit', app.handleReviewSubmitForm);


    },

    handleVideogameSelected: function(evt) {

        // Fetches the VALUE of the <select> element (videogame's id)
        let select = evt.currentTarget;

        // Fetches the INPUT of <select> element
        let id = select.value;

        // Empties content of div#review (each time page is refreshed, the div empties and each time new game is selected 
        //a new template is displayed)
        document.getElementById('review').textContent = "";

        // Get videogame's data from API

        let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        }

        // We specify the endpoint, that is, the GET route that not just the game but also its id AND the reviews associated with it

        let url = 'http://localhost/Perso/videogames/backend/public/videogames/' + id + '/reviews';

        let request = fetch(url, fetchOptions);

        request.then(function(responseJSON) {
            return responseJSON.json();
        }).then(function(reviews) {
            console.log(reviews);


            for(let review of reviews) {
                // Clones/duplicates template #reviewTemplate  and customizes its content with data
                let template = document.getElementById('reviewTemplate').content.cloneNode(true);

                // First we ADD into template (template.) the class name found the in HTML tag
                // Then we INSERT textContent using the index (review) that browses through array (reviews) ...
                // ... and fetches data into each field (title, content, author etc) from the JSON object         
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

                // Template is then inserted into DOM :
                //  - We target the div with id "review"
                //  - We then insert template using appendChild and by targeting ".reviewContainter"
                document.getElementById('review').appendChild(template.querySelector('.reviewContainer'));
            }
        });
        
    },

    handleClickToAddVideogame: function() {
        // https://getbootstrap.com/docs/4.4/components/modal/#modalshow
        $('#addVideogameModal').modal('show');
    },

     handleClickToAddReview: function() {
        // https://getbootstrap.com/docs/4.4/components/modal/#modalshow
        $('#addReviewModal').modal('show');
    },

    // Method handleVideogameSubmitForm allows us to add a new game into database

    handleVideogameSubmitForm: function() {

        // Fetches the input element
        let newGameNameElement = document.getElementById('inputName');
        // Fetches the value of input element (the value entered by USER)
        let newGameName = newGameNameElement.value;

        let newGameEditorElement = document.getElementById('inputEditor');
        let newGameEditor = newGameEditorElement.value;

        // Fetches value of <select> (videogame id)
        let platformSelect = document.getElementById('inputPlatform');
        let platformId = platformSelect.value;

        // Call to API

        let data = {
            'name': newGameName,
            'editor': newGameEditor,
            'platform': platformId,
        };

        // Prompts HTTP headers of request so as to specify data is in JSON
        let myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        // Sends data to API
        let fetchOptions = {
        method: 'POST',
        // Adds headers
        headers: myHeaders,
        // Adds JSON encoded data into the body of the request
        body: JSON.stringify(data)
    };

    const url = 'http://localhost/Perso/videogames/backend/public/videogames';
    fetch(url, fetchOptions)
      .then(function(response) {  // response has been retrieved, then interpreted as JSON
        return response.json();
      })   
        
    },

    // Method handleReviewSubmitForm allows to add a new review into database
    // AND also attach it to any videogame
    // (works exactly like above method)

     handleReviewSubmitForm: function() {

        let newReviewTitleElement = document.getElementById('inputTitle');
       
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
     
        let videogameToReviewSelect = document.getElementById('inputVideogameToReview');

        // Retrieves videogame's id from <select>
        let videogameId = videogameToReviewSelect.value;

        // Call to API

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

        let myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        let fetchOptions = {
        method: 'POST',
        headers: myHeaders,
        body: JSON.stringify(data)
    };

    const url = 'http://localhost/Perso/videogames/backend/public/reviews';
    fetch(url, fetchOptions)
      .then(function(response) {  
        return response.json();
      })   
        
    },

    loadVideoGames: function() {
          
        // Loads all videogame data
         let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        }

        let url = 'http://localhost/Perso/videogames/backend/public/videogames';

        let request = fetch(url, fetchOptions);

        request.then(function(responseJSON) {
            return responseJSON.json();
        }).then(function(videogames) {

            // Let's now save all videogames into an array
            // videogame ids will server as indexes
            
            let videogamesListing = {};
             
            //  for each game ; we'll add an <option> tag to the <select> element
            
            for(let videogame of videogames) {
                // videogame ids will server as indexes
                let videogameId = videogame.id;
                videogamesListing[videogameId] = videogame;

                 //-- VIDEOGAME LIST FOR <SELECT> ELEMENT --//

                // Fetches <select> in DOM
                let videogameListSelectElement = document.getElementById('videogameId');
                // Creates <option> element
                let videogameListOptionElement = document.createElement('option');
                // Customizes option element
                videogameListOptionElement.textContent = videogame.name; // text content of <option> is title of videogame
                videogameListOptionElement.setAttribute('value', videogame.id); // value attribute of <option> is videogame's id 
                

                // Inserts <option> into <select>
                videogameListSelectElement.appendChild(videogameListOptionElement);

                //-- VIDEOGAME LIST FOR ADD REVIEW MODAL --//

                // Same as above
                let videogameToReviewselectElement = document.getElementById('inputVideogameToReview');
                let videogameToReviewOptionElement = document.createElement('option');
               
                videogameToReviewOptionElement.textContent = videogame.name; //le contenu texte de l'option
                videogameToReviewOptionElement.setAttribute('value', videogame.id);
                
                videogameToReviewselectElement.appendChild(videogameToReviewOptionElement);

            }

        });
            
    },

    // In the same way as loadVideoGames, this method loads all platforms but for the "add game" modal

    loadPlatforms: function() {
         let fetchOptions = {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache'
        }

        let url = 'http://localhost/Perso/videogames/backend/public/platforms';

        let request = fetch(url, fetchOptions);

        request.then(function(responseJSON) {
            return responseJSON.json();
        }).then(function(platforms) {
            
            let platformsListing = {};
             
            
            for(let platform of platforms) {
                let platformId = platform.id;
                platformsListing[platformId] = platform;

                let selectElement = document.getElementById('inputPlatform');
                let optionElement = document.createElement('option');
             
                optionElement.textContent = platform.name; 
                optionElement.setAttribute('value', platform.id);
                
                selectElement.appendChild(optionElement);
            }

        });
            
    },
};

document.addEventListener('DOMContentLoaded', app.init);