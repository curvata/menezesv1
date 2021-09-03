// Interface pour gérer les images d'un projet dans l'administration

let picturesFile = document.querySelector('[data-project]');
if (picturesFile) {
    let projectID = picturesFile.dataset.project;
    getPictures(projectID);
}

// Récupérer les images
function getPictures(id) {
    fetch('/admin/pictures/project/'+id)
    .then((response) => { return response.json(); })
    .then(response => { 
        createImg(response);
        delPicture(id);    
    });
}

// Afficher les images
function createImg(response) {
    if (response) {
        let pictureFile = document.querySelector('.pictures');
        pictureFile.innerHTML = '';

        response.forEach(elem => {
        let div = document.createElement('div');
        div.classList.add('picture');
        let img = document.createElement('img');
        img.name = elem[0];
        img.src = '../../../../images/projets/' + elem[1];
        div.append(img);
        pictureFile.append(div);
        });
    }
}

// Supprimer une image
function delPicture(id) {
let pictureFilelocation = document.querySelectorAll('.picture');
    pictureFilelocation.forEach( elem => {
        elem.addEventListener('mouseover', (event) => { 
            let btnDelete = document.createElement('img');
            btnDelete.classList.add('remove');
            btnDelete.src = '../../../../images/icones/delete.png';
            elem.append(btnDelete); 

            btnDelete.addEventListener('click', null, false);
        });

        elem.addEventListener('mouseout', (event) => {
            let btnDelete = document.querySelector('.remove');
            btnDelete.remove();
        });

        elem.addEventListener('click', (event) => { 
            let idPicture = elem.firstChild.name;
            fetch('/admin/pictures/project/delete/'+idPicture, {
                method: 'DELETE'
            }).then(response => {
                if (response.status === 200) {
                    getPictures(id);
                }
            });
        });
    });
}