// const items = document.querySelectorAll('img');
// const nbSlide = items.length;
// const suivant = document.querySelector('.right');
// const precedent = document.querySelector('.left');
// let count = 1;                                              //count = 0

// function slideSuivante(){
//     items[count].classList.remove('active');                                

//     if(count < nbSlide - 1){
//         count++;
//     } else {
//         count = 1;                                  //count = 0;
//     }

//     items[count].classList.add('active')
//     console.log(count);
    
// }
// suivant.addEventListener('click', slideSuivante)


// function slidePrecedente(){
//     items[count].classList.remove('active');

//     if(count > 1){                                          //count > 0
//         count--;                                                                             js du slide menu
//     } else {
//         count = nbSlide - 1;
//     }

//     items[count].classList.add('active')
//      console.log(count);
    
// }
// precedent.addEventListener('click', slidePrecedente)

const conteneurMenu = document.querySelector('#conteneur-menu');
const btnMenu = document.querySelector('#bouton-menu');
const btnFlottant = document.querySelectorAll('.boule');
const texte = document.querySelector('.selectionEspace');
// retourCouleur = document.querySelector('#container-menu');
// boutonretour = document.querySelector('#btn-menu');
console.dir(btnFlottant.length);






btnMenu.addEventListener('click', () => {

    conteneurMenu.classList.toggle('active');

    if ( conteneurMenu.style.backgroundColor=='transparent') {
        conteneurMenu.style.backgroundColor='white' ;
    } 
    
    else {
        conteneurMenu.style.backgroundColor='transparent';
    }

    // if (btnMenu.style.width == '100px' && btnMenu.style.height == '100px') {
    //     btnMenu.classList.add('.disparition');
    //     texte.style.display = 'none'

    // } 
    
    // // else {
       
    // // }

     
  });


// btnMenu.addEventListener('click', () => {

//     containerMenu.classList.toggle('active');

//     if ( containerMenu.style.transform=='scale(1)') {
//         containerMenu.style.transform='scale(0)' ;
//     } 
    
//     else {
//         containerMenu.style.style.transform ='scale(1)';
//     }

     
//   });
  


  


    
//     btnFlottant.forEach((e) => {
//         e.classList.add('sous-bouton');    
//     })
