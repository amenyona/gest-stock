<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title" key="t-menu">Menu</li>

    <li>
        <a href="{{route('dashboard')}}" class="waves-effect">
            <i class="bx bx-home-circle"></i>
            <span key="t-dashboards">Dashboards</span>
        </a>
   
    </li>
    @if(renvoiRoleAdminn(Auth::user()->id) || renvoiRoleControlleur(Auth::user()->id)) 
    <li>
        <a href="{{route('roles.index')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Rôle</span>
        </a>
    </li>


    <li>
        <a href="{{route('user.index')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Utilisateurs</span>
        </a>
    </li>

    <li>
        <a href="{{route('fournisseur.index')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Fournisseurs</span>
        </a>
    </li>

    <li>
        <a href="{{route('famille.index')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Familles</span>
        </a>
    </li>

    <li>
        <a href="{{route('forme.index')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Formes</span>
        </a>
    </li>

    <li>
        <a href="{{route('produit.index')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Produits</span>
        </a>
    </li>
    
 
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-tone"></i>
            <span key="t-ui-elements">Stocks</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{route('stock.liststock')}}" key="t-alerts">Stocks disponibles</a></li>
            <li><a href="{{route('requete.requeteFiche')}}" key="t-buttons">Stocks alerte et seuil</a></li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="bx bx-tone"></i>
            <span key="t-ui-elements">Commandes Fournisseurs</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{route('fournisseur.indexCommandesFournisseur')}}" key="t-alerts">Consulter commandes</a></li>
            <li><a href="{{route('fournisseur.indexCommande')}}" key="t-buttons">Créer commandes</a></li>
        </ul>
    </li>
    

    <li>
        <a href="{{route('fournisseur.rechercherLesommandes')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Traiter les commandes</span>
        </a>
    </li>
    <!--<li>
        <a href="{{route('medecin.liste')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Liste des médecins</span>
        </a>
    </li>
    <li>
        <a href="{{route('patient.liste')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Liste des patients</span>
        </a>
    </li>-->
    <li>
        <a href="{{route('client.liste')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Liste des clients</span>
        </a>
    </li>
    @endif
    @if(renvoiRoleAdminn(Auth::user()->id) || renvoiRoleControlleur(Auth::user()->id) || renvoiRoleCaissier(Auth::user()->id) || renvoiRolePharmacien(Auth::user()->id)) 
    <li>
        <a href="{{route('ventes.create')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Vendre les produits</span>
        </a>
    </li>
    <li>
        <a href="{{route('ventes.listes')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Liste des ventes</span>
        </a>
    </li>
    <li>
        <a href="{{route('ordonnance.create')}}" class="waves-effect">
            <i class="bx bx-chat"></i>
            <span key="t-chat">Vente de produits en rapport avec une ordonnance</span>
        </a>
    </li>
    @endif
    
    

    
  
    
    

    

</ul>