import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../Stores/auth';

const routes = [
    {
        path: "/:notFound",
        component: () => import('../web/ContactoCom.vue'),
    },
    //Routas de sitio web publicas
    {
        path: '/',
        redirect: '/principal',
        component: () => import('../layouts/website.vue'),
        children: [
            {
                name: 'principal',
                path: 'principal',
                component: () => import('../web/HomeCom.vue'),
            },
            {
                name: 'PilotosWeb',
                path: '/PilotosWeb',
                component: () => import('../ComponentesApp/Pilotos/Pilotos.vue')
            },
            {
                name: 'servicios-mecanicosWeb',
                path: '/servicios-mecanicosWeb',
                component: () => import('../ComponentesApp/ServiciosMecanicos/ServiciosPerfiles.vue')
            },
        ],
        meta: { requiresAuth: false }
    },

    //Rutas publicas
    {
        path: '/IniciarSesion',
        component: () => import('../web/Login.vue'),
        meta: { requiresAuth: false }
    },
    {
        path: '/OpcionesRegistro',
        component: () => import('../web/Registro/OpcionesRegistro.vue'),
        meta: { requiresAuth: false }
    },
    {
        path: '/RegistroMecanicos',
        component: () => import('../web/Registro/RegistroMecanico.vue'),
        meta: { requiresAuth: false }
    },
    {
        path: '/RegistroConductores',
        component: () => import('../web/Registro/RegistroConductor.vue'),
        meta: { requiresAuth: false }
    },

    //Rutas que requiren Iniciar Sesion
    {
        path: '/App',
        redirect: '/dashboard',
        component: () => import('../layouts/aplication.vue'),
        children: [
            {
                name: 'dashboard',
                path: '/dashboard',
                component: () => import('../web/HomeCom.vue'),
            },
            {
                name: 'homesite',
                path: '/homesite',
                component: () => import('../web/HomeCom.vue')
            },
            {
                name: 'perfil',
                path: '/perfilUsuario',
                component: () => import('../ComponentesApp/Perfil/VerPerfil.vue')
            },
            {
                name: 'Pilotos',
                path: '/Pilotos',
                component: () => import('../ComponentesApp/Pilotos/Pilotos.vue')
            },
            {
                name: 'verPiloto',
                path: '/verPiloto/:id',
                component: () => import('../ComponentesApp/Pilotos/VerPiloto.vue')
            },
            {
                name: 'crearPilotos',
                path: '/crearPilotos',
                component: () => import('../ComponentesApp/Pilotos/CrearPiloto.vue')
            },
            {
                name: 'servicios-mecanicos',
                path: '/servicios-mecanicos',
                component: () => import('../ComponentesApp/ServiciosMecanicos/ServiciosPerfiles.vue')
            },
            {
                name: 'verServicio',
                path: '/verServicio/:id',
                component: () => import('../ComponentesApp/ServiciosMecanicos/verServicio.vue')
            },
            {
                name: 'inscripcionServicios',
                path: '/inscripcionServicios',
                component: () => import('../ComponentesApp/ServiciosMecanicos/InscripcionServicios.vue')
            },
            {
                name: 'inscribirServicio',
                path: '/inscribirServicio',
                component: () => import('../ComponentesApp/ServiciosMecanicos/InscribirServicio.vue')
            },
            {
                name: 'modificarServicio',
                path: '/modificarServicio/:id',
                component: () => import('../ComponentesApp/ServiciosMecanicos/EditarServicio.vue')
            },
            {
                name: 'conductorServicios',
                path: '/serviciosContratados',
                component: () => import('../ComponentesApp/Contratacion/ConductorServicios.vue')
            },
            {
                name: 'mecanicosServicios',
                path: '/serviciosActivos',
                component: () => import('../ComponentesApp/Contratacion/MecanicoServicio.vue')
            },
            {
                name: 'verPerfilMecanico',
                path: '/verPerfilMecanico/:id',
                component: () => import('../ComponentesApp/PerfilMecanico/verPerfil.vue')
            },
            {
                name: 'crearPerfilMecanico',
                path: '/crearPerfilMecanico',
                component: () => import('../ComponentesApp/PerfilMecanico/crearPerfilMecanico.vue')
            },
            {
                name: 'perfilMecanico',
                path: '/perfilMecanico',
                component: () => import('../ComponentesApp/PerfilMecanico/showOrEdit.vue'),

            },
            {
                name: 'manuales',
                path: '/manuales',
                component: () => import('../ComponentesApp/Manuales/manuales.vue')
            }

        ],
        meta: { requiresAuth: true }
    }
];



const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

router.beforeEach(async (to) => {
    const auth = useAuthStore();
    const requiresAuth = to.meta.requiresAuth;

    if (requiresAuth && !auth.user) {
        return '/IniciarSesion';
    }
});

// router.beforeEach( async(to) =>{
//     const publicPages = ['/IniciarSesion','/OpcionesRegistro','/principal', ]
//     const authRequired = !publicPages.includes(to.path)
//     const auth = useAuthStore()
//     if(authRequired && !auth.user){
//         auth.returnUrl = to.fullPath
//         return '/IniciarSesion'
//     }
// })

export default router;
