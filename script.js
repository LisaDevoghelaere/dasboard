// Les variables
//variable du "bouton" poubelle
const deleteLinks = document.getElementsByClassName('btn_delete');

//bouton non
const btnNo = document.getElementById('modal_no');

//bouton oui
const btnYes = document.getElementById('modal_yes');

//Boucle qui va affecter l'évènement clic à tous les liens <a> ayant la classe btn_delete
for( deleteLink of deleteLinks ){
    // Affecte l'évenement click
    deleteLink.addEventListener('click', function(e){
    // pour ne pas executer les évènements par défauts (là aller sur la page delete.php)
    e.preventDefault();
    //console.log('test');
    //Selectionne l'element ayant l'id modal
    const modal = document.getElementById('modal');
    //console.log(modal);
    modal.classList.toggle('hidden');

    //ajout de la classe ready-to-delete au lien que l'on vient de cliquer
    this.classList.toggle('ready-to-delete');
    });
}

// Ajout de lévènement clic au bouton non
btnNo.addEventListener('click', function(){
    //console.log('coucou');
    const modal = document.getElementById('modal');
    modal.classList.toggle('hidden');
    
    // on fait une sélection du lien ayant la classe ready-to-delete
    const elementsToDelete = document.getElementsByClassName('ready-to-delete')
    for(elementToDelete of elementsToDelete){
        elementToDelete.classList.toggle('ready-to-delete');
    }
});
// Ajout de l'évènement clic au bouton oui
btnYes.addEventListener('click', function(){
    //console.log('coucou');
    //return;
    const modal = document.getElementById('modal');
    modal.classList.toggle('hidden');

     const elementsToDelete = document.getElementsByClassName('ready-to-delete')
     for(elementToDelete of elementsToDelete){
        location.href = elementToDelete.getAttribute('href');       
    }
});