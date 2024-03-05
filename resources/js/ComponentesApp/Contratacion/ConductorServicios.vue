<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Servicios Contratados</h3>
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

        <v-row v-if="loading" v-model="loading" class="fill-height" align-content="center" justify="center">
            <v-col class="text-subtitle-1 text-center" cols="12">
                Cargando contrataciones
            </v-col>
            <v-col cols="6">
                <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
            </v-col>
        </v-row>

        <v-alert v-else-if="!status" color="error" icon="$error" :text="'No se encontraron contrataciones' || message">
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
                                        <v-chip variant="elevated" :color="servicio.estado.color" class="ma-2"
                                            :prepend-icon="servicio.estado.icon">
                                            {{ servicio.estado.estado }}
                                        </v-chip>
                                    </div>
                                    <div v-if="servicio.mecanico.nombre_taller == null" class="d-flex flex-column align-center">
                                        Mecanico
                                        <v-chip variant="elevated"  class="ma-2"
                                            prepend-icon="mdi-account-circle">
                                            {{ servicio.mecanico.representante }}
                                        </v-chip>
                                    </div>
                                    <div v-else class="d-flex flex-column align-center">
                                        Taller Mecanico
                                        <v-chip variant="elevated"  class="ma-2"
                                            prepend-icon="mdi-account-circle">
                                            {{ servicio.mecanico.nombre_taller }}
                                        </v-chip>
                                    </div>
                                    
                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-divider ></v-divider>
                    <v-card-actions class="d-flex flex-row justify-space-between gap-10"
                        v-if="servicio.estado.estado === 'Activo'">
                        <div class="d-flex flex--row gap-10">
                            <detalleContratacion type="text" :id="servicio.id" mode="detalles"></detalleContratacion>
                            <CancelarRechazar title="Cancelar" type="text" :id="servicio.id" @actualizar="cargarDatos()"></CancelarRechazar>
                        </div>

                        <v-btn class="bg-grey2" size="small" icon>
                            <v-icon>mdi-message-outline</v-icon>
                            <v-tooltip activator="parent" location="top">Chat</v-tooltip>
                        </v-btn>
                    </v-card-actions>
                    <v-card-actions class="d-flex flex-row justify-space-between gap-10"
                        v-else-if="servicio.estado.estado === 'En espera'">
                        <div class="d-flex flex-row gap-10">
                            <detalleContratacion type="text" :id="servicio.id" mode="detalles"></detalleContratacion>

                            <detalleContratacion type="text" :id="servicio.id" mode="modificar"></detalleContratacion>

                            
                            <CancelarRechazar title="Cancelar" type="text" :id="servicio.id" @actualizar="cargarDatos()"></CancelarRechazar>
                        </div>

                        <Observacion title="Ver" type="text" :id="servicio.id" @actualizar="cargarDatos()"></Observacion>
                    </v-card-actions>

                    <v-card-actions class="d-flex justify-space-between" v-else-if="servicio.estado.estado === 'Rechazado'">
                        <div class="d-flex flex-row gap-10">
                            <detalleContratacion type="text" :id="servicio.id" mode="detalles"></detalleContratacion>
                            <VerRechazo :id="servicio.id" type="text"></VerRechazo>
                        </div>
                    </v-card-actions>
                    <!-- <v-card-actions class="d-flex justify-space-between" v-else-if="servicio.estado.estado === 'Completado'">
                        <div class="d-flex flex-row gap-10">
                            <detalleContratacion type="text" :id="servicio.id"></detalleContratacion>
                        </div>
                    </v-card-actions> -->
                </v-card>
            </v-col>
        </v-row>
        <div v-if="status" class="text-center pt-2">
            <v-pagination v-model="currentPage" :length="last_page" @click="cargarDatos"></v-pagination>
        </div>

    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Observacion from './Modales/Observacion.vue';
import VerRechazo from './Modales/VerRechazo.vue';
import CancelarRechazar from './Modales/CancelarRechazar.vue';
import detalleContratacion from './Modales/DetallesContratacion.vue';
import notify from '@/plugins/notify.js';
import { getData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';
import { format } from 'date-fns';

const authStore = useAuthStore();


const servicios = ref([]);
const loading = ref(true);
const status = ref(false);
const message = ref('');
const selectedEstado = ref('');
const items = ref([]);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const last_page = ref(null);

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

const getContrataciones = async (id) => {
    try {
        const data = await getData(('contrataciones/' + id + '?page=' + currentPage.value + '&estado=' + selectedEstado.value));
        if (!data.status) {
            status.value = data.status;
            message.value = data.message;
        }else{
            status.value = data.status;
            servicios.value = data.data.data;
            itemsPerPage.value = data.data.per_page;
            currentPage.value = data.data.current_page;
            last_page.value = data.data.last_page;
            console.log('data', servicios.value);
        }
        
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
};

const cargarDatos = async () => {
    await getContrataciones(authStore.user.id)
}

const cleanSearch = () => {
    selectedEstado.value = '';
    cargarDatos();
}

onMounted(() => {
    getContrataciones(authStore.user.id);
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