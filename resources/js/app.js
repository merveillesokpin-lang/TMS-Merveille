import './bootstrap'; // L'import d'Axios par défaut de Laravel
import { createApp } from 'vue';

// 1. Import des styles des librairies installées
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'aos/dist/aos.css';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'glightbox/dist/css/glightbox.min.css';

// 2. Import du CSS personnalisé de votre template LeadPage
// (Assurez-vous d'avoir copié le fichier CSS du template dans ce dossier)
import '../css/app.css'; 

// 3. Import de votre composant principal de page d'accueil
import Home from './components/Home.vue'; // Nous allons créer ce composant à l'étape suivante

const app = createApp(Home);
app.mount('#app');
