<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Servicios Activos</h3>
        </div>

        <v-card class="busquedaStyle mb-5">
            <v-card-Text>
                <v-form>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-select v-model="selectedEstado" prepend-inner-icon="mdi-car-search" label="Estado"
                                :items="items" variant="solo" item-title="estado" item-value="id"
                                hide-details="auto"></v-select>
                        </v-col>
                        <v-col cols="12" md="5"
                            class="d-flex flex-column flex-sm-row align-center justify-center justify-md-start"
                            style="gap:10px;">
                            <v-btn @click="cargarDatos()" prepend-icon="mdi-magnify" class="blueButton px-8">
                                Buscar
                            </v-btn>
                            <v-btn @click="cleanSearch()" prepend-icon="mdi-trash-can" class="greyButton px-8">
                                Limpiar
                            </v-btn>
                        </v-col>
                    </v-row>


                </v-form>
            </v-card-Text>
        </v-card>


        <v-tabs v-model="tab" color="blue" bg-color="transparent" align-tabs="start">
            <v-tab value="card">
                <v-icon>mdi-view-grid-outline</v-icon>
            </v-tab>
            <v-tab value="table">
                <v-icon>mdi-table</v-icon>
            </v-tab>
        </v-tabs>

        <v-window v-model="tab">
            <v-window-item value="card">
                <v-container fluid>
                    <v-row v-if="loading" v-model="loading" class="fill-height" align-content="center" justify="center">
                        <v-col class="text-subtitle-1 text-center" cols="12">
                            Cargando contrataciones
                        </v-col>
                        <v-col cols="6">
                            <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
                        </v-col>
                    </v-row>

                    <v-alert v-else-if="!status" color="error" icon="$error"
                        :text="'No se encontraron contrataciones' || message">
                    </v-alert>

                    <v-row v-else-if="status">
                        <v-col cols="12" sm="6" v-for="(servicio, index) in servicios" :key="index">
                            <v-card class="bg-secondary" variant="outlined" hover>
                                <v-card-text>
                                    <v-row align="center">
                                        <v-col cols="12" md="4">
                                            <v-img :src="servicio.servicio.logo" max-height="200"></v-img>
                                        </v-col>
                                        <v-col cols="12" md="8">
                                            <v-card-title class="text-h5 font-weight-bold item-texto">
                                                {{ servicio.servicio.servicio }}
                                            </v-card-title>
                                            <v-card-subtitle class="item-texto">
                                                Fecha contratación: {{ formatDate(servicio.fecha_contratacion) }}
                                            </v-card-subtitle>

                                            <v-card-text class="d-flex justify-space-between flex-column flex-lg-row">

                                                <div class="d-flex flex-column align-center">
                                                    Estado
                                                    <v-chip variant="elevated" :color="servicio.estado.color"
                                                        class="ma-2" :prepend-icon="servicio.estado.icon">
                                                        {{ servicio.estado.estado }}
                                                    </v-chip>
                                                </div>
                                                <div class="d-flex flex-column align-center">
                                                    Usuario
                                                    <v-chip variant="elevated" class="ma-2"
                                                        prepend-icon="mdi-account-circle">
                                                        {{ servicio.conductor.nombre }}
                                                    </v-chip>
                                                </div>
                                            </v-card-text>

                                        </v-col>
                                    </v-row>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions class="d-flex flex-row justify-space-between gap-10"
                                    v-if="servicio.estado.estado === 'Activo'">
                                    <div class="d-flex flex-row gap-10">

                                        <completado :id="servicio.id" type="text" @actualizar="getPerfil()">
                                        </completado>

                                        <v-btn class="bg-grey2" icon>
                                            <v-icon>mdi-message-outline</v-icon>
                                            <v-tooltip activator="parent" location="top">Chat</v-tooltip>
                                        </v-btn>
                                    </div>

                                    <CancelarRechazar :id="servicio.id" title="Rechazar" type="text"
                                        @actualizar="getPerfil()"></CancelarRechazar>

                                </v-card-actions>
                                <v-card-actions class="d-flex flex-row justify-space-between gap-10"
                                    v-else-if="servicio.estado.estado === 'En espera'">
                                    <div class="d-flex flex-row gap-10">
                                        <AceptarServicio :id="servicio.id" type="text" @actualizar="getPerfil()">
                                        </AceptarServicio>
                                        <CancelarRechazar :id="servicio.id" title="Rechazar" type="text"
                                            @actualizar="getPerfil()"></CancelarRechazar>
                                    </div>
                                    <Observacion :id="servicio.id" @actualizar="cargarDatos()" title="Crear"
                                        type="text"></Observacion>

                                </v-card-actions>

                                <v-card-actions class="d-flex justify-space-between"
                                    v-else-if="servicio.estado.estado === 'Rechazado'">
                                    <div class="d-flex flex-column flex-sm-row gap-10">
                                        <VerRechazo :id="servicio.id" type="text"></VerRechazo>
                                    </div>
                                </v-card-actions>
                            </v-card>
                        </v-col>

                    </v-row>
                    <div v-if="status" class="text-center pt-2">
                        <v-pagination v-model="currentPage" :length="last_page" @click="cargarDatos"></v-pagination>
                    </div>
                </v-container>
            </v-window-item>
            <v-window-item value="table">
                <v-container fluid>
                    <v-data-table :headers="headers" :items="servicios" :items-per-page="itemsPerPage"
                        :loading="loading" loading-text="Cargando contrataciones"
                        no-data-text="No se encontraron contrataciones">

                        <template v-slot:item.servicio.logo="{ item }">
                            <v-card class="my-2" elevation="2" rounded>
                                <v-img :src="item.servicio.logo" height="64" cover></v-img>
                            </v-card>
                        </template>

                        <template v-slot:item.fecha_contratacion="{ item }">
                            {{ formatDate(item.fecha_contratacion) }}
                        </template>

                        <template v-slot:item.estado="{ item }">
                            <v-chip :color="item.estado.color" class="text-uppercase" label size="small"
                                :prepend-icon="item.estado.icon">
                                {{ item.estado.estado }}
                            </v-chip>
                        </template>

                        <template v-slot:item.servicio.conductor="{ item }">
                            <v-chip label size="small" prepend-icon="mdi-account-circle">
                                {{ item.conductor.nombre }}
                            </v-chip>
                        </template>

                        <template v-slot:item.acciones="{ item }">
                            <div v-if="item.estado.estado === 'Activo'">
                                <completado :id="item.id" type="icon" @actualizar="getPerfil()"></completado>
                                <v-btn variant="flat" density="compact" icon="mdi-message-outline"></v-btn>
                                <CancelarRechazar :id="item.id" title="Rechazar" type="icon" @actualizar="getPerfil()">
                                </CancelarRechazar>
                            </div>

                            <div v-else-if="item.estado.estado === 'En espera'">
                                <AceptarServicio :id="item.id" type="icon" @actualizar="getPerfil()"></AceptarServicio>
                                <CancelarRechazar :id="item.id" title="Rechazar" type="icon" @actualizar="getPerfil()">
                                </CancelarRechazar>
                                <Observacion :id="item.id" @actualizar="cargarDatos()" title="Crear" type="icon">
                                </Observacion>
                            </div>

                            <div v-else-if="item.estado.estado === 'Rechazado'">
                                <VerRechazo :id="item.id" type="icon"></VerRechazo>
                            </div>
                        </template>

                        <template v-slot:bottom>
                            <div class="text-center pt-2">
                                <v-pagination v-model="currentPage" :length="last_page"
                                    @click="cargarDatos"></v-pagination>
                            </div>
                        </template>
                    </v-data-table>
                </v-container>
            </v-window-item>
        </v-window>


    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AceptarServicio from './Modales/AceptarServicio.vue';
import Observacion from './Modales/Observacion.vue';
import VerRechazo from './Modales/VerRechazo.vue';
import completado from './Modales/completado.vue';
import CancelarRechazar from './Modales/CancelarRechazar.vue';
import notify from '@/plugins/notify.js';
import { getData, postData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';
import { format } from 'date-fns';

const authStore = useAuthStore();
const tab = ref('table');

const currentPage = ref(1);
const itemsPerPage = ref(10);
const last_page = ref(null);

const headers = ref([
    { title: 'Imagen', value: 'servicio.logo' },
    { title: 'Servicio', value: 'servicio.servicio' },
    { title: 'Fecha de contratación', value: 'fecha_contratacion' },
    { title: 'Usuario', value: 'servicio.conductor' },
    { title: 'Estado', value: 'estado' },
    { title: 'Acciones', value: 'acciones' }
])

const servicios = ref([])
const loading = ref(true);
const status = ref(false);
const message = ref('');
const idGlobal = ref(null);
const items = ref([]);
const selectedEstado = ref('');


const getEstados = async () => {
    try {
        const data = await getData(('estados'));

        items.value = data.data
        console.log('estados', items.value)

    } catch (error) {
        notify(error.message, 'error');
    }
};

const formatDate = (dateTime) => {
    if (!dateTime) return '';

    const dateTimeObj = new Date(dateTime);
    return format(dateTimeObj, 'dd/MM/yyyy hh:mm a');
};


const getPerfil = async () => {
    try {
        const id = authStore.authUser.id;
        const data = await getData(('verificarPerfil/' + id));

        if (!data.status) {
            notify('No se encontro perfil mecanico', 'info')
            setTimeout(() => router.push({ path: 'perfilMecanico' }), 3000)
        }
        idGlobal.value = data.id
        getContrataciones(data.id);

    } catch (error) {
        notify(error.message, 'error');
    }
};

const getContrataciones = async (id) => {
    try {
        const data = await getData(('contrataciones/' + id + '?page=' + currentPage.value + '&estado=' + selectedEstado.value));

        if (!data.status) {
            status.value = data.status;
            message.value = data.message;
            servicios.value = [];
        } else {
            status.value = data.status;
            servicios.value = data.data.data;
            itemsPerPage.value = data.data.per_page;
            currentPage.value = data.data.current_page;
            last_page.value = data.data.last_page;

            console.log('data', data.data.current_page);
        }

    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
};

const cargarDatos = async () => {
    await getContrataciones(idGlobal.value)
}

const cleanSearch = () => {
    selectedEstado.value = '';
    cargarDatos();
}

onMounted(() => {
    getPerfil();
    getEstados();
})
</script>

<style>
.v-card-actions .v-btn~.v-btn:not(.v-btn-toggle .v-btn) {
    margin-inline-start: 0 !important;
}

.v-table__wrapper thead {
    background-color: #1279C1;
    color: #FFFFFF;
}
</style>