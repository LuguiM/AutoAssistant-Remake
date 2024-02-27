<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Inscripcion de servicios</h3>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-space-between aling-center">
            <v-btn class="mt-5 bg-greyDark" prepend-icon="mdi-car-wrench" @click="requisitosModal = true">
                Requisitos de inscripcion
            </v-btn>

            <v-btn class="mt-5 bg-primary" prepend-icon="mdi-car-wrench" :to="{ path: '/inscribirServicio' }">
                Inscribir servicio mecanico
            </v-btn>
        </div>

        <v-row class="mt-5">
            <v-col cols="12">
                <h2>Servicios Inscritos</h2>
            </v-col>

            <v-col cols="12" sm="6" v-if="status" v-for="inscripcion in serviciosInscritos" :key="inscripcion.id">
                <v-card class="inscritoCard">
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-img height="76" :src="inscripcion.logo"></v-img>
                            </v-col>

                            <v-col cols="12" md="8">
                                <v-card-title class="text-h5 font-weight-bold item-texto">
                                    {{ inscripcion.servicio }}
                                </v-card-title>
                                <v-card-subtitle>
                                    Fecha de creación: {{ formatFecha(inscripcion.created_at) }}
                                </v-card-subtitle>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="text-center">
                        <editarServicio :id="inscripcion.id"></editarServicio>
                        <v-spacer></v-spacer>
                        <v-btn class="bg-error" prepend-icon="mdi-delete-outline" @click="eliminarServicio(inscripcion.id)">
                            Eliminar
                        </v-btn>
                    </v-card-actions>
                </v-card>


            </v-col>

            <v-col v-else cols="12">
                <v-alert color="error" icon="$error" :text="message || 'No se encontraron servicios mecánicos inscritos'">
                </v-alert>
            </v-col>
        </v-row>
        <v-pagination v-if="status" v-model="currentPage" :length="last_page" @click="cargarServicios" class="my-4"></v-pagination>



        <v-dialog width="auto" v-model="eliminarModal">
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar servicio</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>¿Esta seguro de querer eliminar este servicio?</v-card-text>
                <v-card-text class="pt-0">Esta accion sera irreversible</v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn :loading="cargandoDelete" class="bg-primary" @click="inscripcionEliminada">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="requisitosModal" width="auto">
            <v-card class="bg-greyDark">
                <v-card-title class="d-flex justify-space-between aling-center">
                    <h3> Requisitos </h3>
                    <v-btn variant="plain" icon @click="requisitosModal = false"><v-icon>mdi-close</v-icon></v-btn>
                </v-card-title>
                <v-list lines="two" class="py-0">
                    <v-list-item v-for="requisito in requisitos" :key="requisito.title" class="itemsRequisitos">
                        <v-list-item-title class="item-texto">
                            {{ requisito.title }}
                        </v-list-item-title>
                        <v-list-item-subtitle class="item-texto">
                            {{ requisito.contenido }}
                        </v-list-item-subtitle>
                        <template v-slot:append>
                            <v-chip variant="flat" color="green" v-if="requisito.requerido == 'Opcional'">
                                {{ requisito.requerido }}
                            </v-chip>
                            <v-chip variant="flat" color="red" v-else>
                                {{ requisito.requerido }}
                            </v-chip>

                        </template>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
import editarServicio from './EditarServicio.vue'
import { ref, onMounted } from 'vue';
import notify from '@/plugins/notify.js';
import { getData, deleteData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';
import { format } from 'date-fns';
import { useRouter } from 'vue-router';

const router = useRouter();

const authStore = useAuthStore();


let eliminarModal = ref(false);
let idServicio = ref(null);
const requisitos = ref([
    {
        title: "Nombre del taller",
        contenido: "Nombre del taller para identificarse.",
        requerido: "Obligatorio"
    },
    {
        title: "Dueño o representante",
        contenido: "Nombre del dueño o un representante del taller",
        requerido: "Obligatorio"
    },
    {
        title: "Rubro",
        contenido: "Area en la que trabajaran",
        requerido: "Obligatorio",
    },
    {
        title: "Direccion",
        contenido: "Direccion del taller mecanico y puntos de referencias",
        requerido: "Obligatorio"
    },
    {
        title: "Servicios que ofrecen",
        contenido: "Nombre dle servicio que ofrece el taller",
        requerido: "Obligatorio"
    },
    {
        title: "Descripcion dle servicio",
        contenido: "Breve descripcion sobre el servicio que se brinda.",
        requerido: "Opcional",
    },
    {
        title: "Tipo de servicio",
        contenido: "El tipo de servicio que ofrecera ya sea adomicilio o con citas previas",
        requerido: "Obligatorio"
    },
    {
        title: "Horario de atencion",
        contenido: "Horarios de atencion a cliente",
        requerido: "Obligatorio"
    },
    {
        title: "Numero de contacto",
        contenido: "Numero telefonico para contactar",
        requerido: "Opcional"
    },
    {
        title: "Logo o imagen del servicio",
        contenido: "Logotipo que represente el taller o una imagen que represente el servicio.",
        requerido: "Obligatorio"
    },
    {
        title: "Acreditaciones",
        contenido: "Imagenes de certificaciones, especializaciones o reconocimientos, Maximo 4",
        requerido: "Opcional"
    }
]);
const requisitosModal = ref(false);
const serviciosInscritos = ref([])
const loading = ref(true);
const status = ref(false);
const message = ref('');
const currentPage = ref(1);
const last_page = ref(null);
const cargandoDelete = ref(false);

const getPerfil = async () => {
    try {
        const id = authStore.authUser.id;
        const data = await getData(('verificarPerfil/' + id));

        if (!data.status) {
            notify('No se encontro perfil mecanico', 'info')
            setTimeout(() => router.push({ path: 'perfilMecanico' }), 3000)
        }

        serviciosMecanicos(data.id);
        
    } catch (error) {
        notify(error.message, 'error');
    } 
};

const serviciosMecanicos = async (id) => {
    try {
        
        const data = await getData(('servicio-mecanico/inscritos/' + id + '?page=' + currentPage.value));


        if (!data.status) {
            status.value = data.status
            message.value = data.message
        } else {
            status.value = data.status;
            serviciosInscritos.value = data.data.data;
            currentPage.value = data.data.current_page;
            last_page.value = data.data.last_page;
        }
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
}

const cargarServicios = async () => {
    await serviciosMecanicos();
}

const formatFecha = (fecha) => {
    return format(new Date(fecha), 'dd/MM/yyyy');
};


const eliminarServicio = (id) => {
    eliminarModal.value = true;
    idServicio.value = id;
}

const inscripcionEliminada = async() => {
    try {
        cargandoDelete.value = true;
        await deleteData(('servicio-mecanico/delete/' + idServicio.value), { headers: { 'Content-Type': 'application/json' } });
    } catch (error) {
        notify(error.message, 'error');
    }  finally {
        cargandoDelete.value = true;
        eliminarModal.value = false;
        idServicio.value = null;
        getPerfil()
    }
    
}

onMounted(() => {
    getPerfil()
});

</script>

<style>
.v-expansion-panel-text__wrapper {
    background-color: #D9D9D9 !important;
}

.itemsRequisitos {
    background-color: #D9D9D9;
    border: #c6c4c4 solid 1px;

}

.inscritoCard {
    background-color: #D9D9D9;
}
</style>