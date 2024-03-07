<template>
    <v-container>
        <v-tabs v-model="tab" color="white" bg-color="primary" align-tabs="center">
            <v-tab value="servicios">
                <v-icon>mdi-car-wrench</v-icon>
                Servicios
            </v-tab>
            <v-tab value="perfiles">
                <v-icon>mdi-account</v-icon>
                Mecanicos
            </v-tab>
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item value="servicios">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12">
                            <v-card class="rubroFilter" variant="outlined">
                                <v-card-title class="text-center">Filtros por rubro</v-card-title>
                                <v-card-text class="d-flex flex-wrap ">
                                    <v-checkbox v-model="searchRubros" v-for="rubro in rubros" :label="rubro.label" :value="rubro.value"
                                        hide-details></v-checkbox>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn @click="getServicios()" variant="tonal" prepend-icon="mdi-magnify" class="mr-3 blueButton">
                                        Filtrar
                                    </v-btn>
                                    <v-btn @click="cleanServicios()" variant="tonal" prepend-icon="mdi-trash-can" class="greyButton">
                                        Limpiar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                        <v-col cols="12">
                            <v-row v-if="loading" class="fill-height" align-content="center" justify="center">
                                <v-col class="text-subtitle-1 text-center" cols="12">
                                    Cargando servicios
                                </v-col>
                                <v-col cols="6">
                                    <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
                                </v-col>
                            </v-row>

                            <v-alert v-else-if="!status" color="error" icon="$error" :text="message">
                            </v-alert>

                            <v-row v-else-if="status">
                                <v-col v-for="servicio in serviciosMecanicos" cols="12" sm="6" md="6">
                                    <v-card class="text-center perfil-card" hover>
                                        <div @click="verServicio(servicio.id)" class="card-body">
                                            <v-row>
                                                <v-col cols="12" md="4">
                                                    <v-avatar color="grey" size="120" class="mt-4">
                                                        <v-img cover :src="servicio.logo"></v-img>
                                                    </v-avatar>
                                                </v-col>
                                                <v-col cols="12" md="8">
                                                    <v-card-title class="text-start">
                                                        {{ servicio.servicio }}
                                                    </v-card-title>
                                                    <v-card-subtitle class="pt-0 text-start">
                                                        <v-icon>mdi-car-cog</v-icon>
                                                        {{ servicio.rubro }}
                                                    </v-card-subtitle>
                                                    <v-card-text class="text-end">
                                                        <div>
                                                            <v-icon>mdi-star-cog-outline</v-icon>
                                                            {{ servicio.tipo_servicio }}
                                                        </div>
                                                        <div>
                                                            <v-icon>mdi-currency-usd</v-icon> {{ servicio.precio }}
                                                        </div>
                                                    </v-card-text>
                                                </v-col>
                                            </v-row>
                                        </div>
                                        <v-card-actions class="bg-primary card-text d-flex justify-center gap-10"
                                            @click="verPerfil(servicio.perfil_mecanico.id)">
                                            <v-avatar color="info" size="x-small" style="border:1px solid #FFFFFF;">
                                                <v-img :src="servicio.perfil_mecanico.logo"
                                                    :alt="servicio.perfil_mecanico.representante"></v-img>
                                            </v-avatar>
                                            <p v-if="servicio.perfil_mecanico?.nombre_taller">{{ servicio.perfil_mecanico.nombre_taller }}</p>
                                            <p v-else>{{ servicio.perfil_mecanico.representante }}</p>
                                        </v-card-actions>

                                    </v-card>

                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-pagination v-if="status" v-model="currentPage" :length="last_page" @click="cargarServicios"
                        class="my-4"></v-pagination>
                </v-container>
            </v-window-item>

            <v-window-item value="perfiles">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12">
                            <v-card class="busquedaPerfil">
                                <v-card-title class="text-center">
                                    Busqueda de perfiles
                                </v-card-title>

                                <v-card-Text>
                                    <v-form>
                                        <v-row>
                                            <v-col cols="12" md="8">
                                                <v-text-field v-model="searchPerfiles" label="Busqueda por taller mecanico o representante"
                                                    prepend-inner-icon="mdi-account-search" variant="solo" ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4" class="d-flex align-center justify-center mb-5">
                                                <v-btn @click="getPerfiles()" variant="tonal" prepend-icon="mdi-magnify" class="mr-3 blueButton">
                                                    Buscar
                                                </v-btn>
                                                <v-btn @click="cleanPerfiles()" variant="tonal" prepend-icon="mdi-trash-can" class="greyButton">
                                                    Limpiar
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-Text>
                            </v-card>
                        </v-col>
                        <v-col cols="12">
                            <v-row v-if="loadingPerfil" class="fill-height" align-content="center" justify="center">
                                <v-col class="text-subtitle-1 text-center" cols="12">
                                    Cargando Perfiles
                                </v-col>
                                <v-col cols="6">
                                    <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
                                </v-col>
                            </v-row>

                            <v-alert v-else-if="!statusPerfil" color="error" icon="$error" :text="messagePerfil">
                            </v-alert>

                            <v-row v-else-if="statusPerfil">
                                <v-col cols="12" sm="6" md="3" v-for="perfil in perfiles">
                                    <v-card class="text-center perfil-card" @click="verPerfil(perfil.id)" hover>
                                        <v-avatar color="grey" size="190" class="mt-4">
                                            <v-img cover :src="perfil.logo"></v-img>
                                        </v-avatar>

                                        <v-card-text>
                                            <v-icon>mdi-account</v-icon>
                                            Representante <br> {{ perfil.representante }}
                                        </v-card-text>
                                        <v-card-text class="pt-0" v-if="perfil?.nombre_taller">
                                            <v-icon>mdi-car-cog</v-icon>
                                            Taller Mecanico <br> {{ perfil.nombre_taller }}
                                        </v-card-text>
                                        <v-card-text class="pt-0" v-else>
                                            <v-icon>mdi-car-cog</v-icon>

                                            Mecanico Independiente
                                        </v-card-text>

                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
                <v-pagination v-if="statusPerfil" v-model="currentPagePerfil" :length="last_pagePerfil"
                    @click="cargarPerfiles" class="my-4"></v-pagination>
            </v-window-item>
        </v-window>
    </v-container>
</template>



<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { getData } from '@/plugins/api.js';
import notify from '@/plugins/notify.js';
import { useAuthStore } from '@/Stores/auth';

const authStore = useAuthStore();

const router = useRouter();
const tab = ref(null);
const rubros = ref([
    {
        label: "Mecanico",
        value: "Mecanico"
    },
    {
        label: "Electronico",
        value: "Electronico"
    },
    {
        label: "Enderezado y Pintura",
        value: "Enderezado y Pintura"
    },
    {
        label: "General de Caja",
        value: "General de Caja"
    },
    {
        label: "Lubricentro",
        value: "Lubricentro"
    },
    {
        label: "Llanteria",
        value: "Llanteria"
    }
]);
const serviciosMecanicos = ref([]);
const perfiles = ref([]);

const loading = ref(true);
const status = ref(false);
const message = ref('');
const currentPage = ref(1);
const last_page = ref(null);
const searchRubros = ref([]);

const loadingPerfil = ref(true);
const statusPerfil = ref(false);
const messagePerfil = ref('');
const currentPagePerfil = ref(1);
const last_pagePerfil = ref(null);
const searchPerfiles = ref('');

const getServicios = async () => {
    try {
    
        const data = await getData(('servicio-mecanico' + '?page=' + currentPage.value + '&rubros=' + searchRubros.value));

        if (!data.status) {
            status.value = data.status
            message.value = data.message
        } else {
            status.value = data.status;
            serviciosMecanicos.value = data.data.data;
            currentPage.value = data.data.current_page;
            last_page.value = data.data.last_page;
            console.log(searchRubros.value)
        }
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
}

const cleanServicios = () => {
    searchRubros.value = [];
    getServicios()
}

const getPerfiles = async () => {
    try {
        const data = await getData(('perfilMecanico' + '?page=' + currentPagePerfil.value + '&search=' + searchPerfiles.value));

        if (!data.status) {
            statusPerfil.value = data.status
            messagePerfil.value = data.message
        } else {
            statusPerfil.value = data.status;
            perfiles.value = data.data.data;
            currentPagePerfil.value = data.data.current_page;
            last_pagePerfil.value = data.data.last_page;
        }
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loadingPerfil.value = false;
    }
}

const cleanPerfiles = () => {
    searchPerfiles.value = '';
    getPerfiles()
}

const cargarServicios = async () => {
    await getServicios();
}
const cargarPerfiles = async () => {
    await getPerfiles();
}

const verServicio = (id) => {
    router.push({ path: `/verServicio/${id}` });
}


const verPerfil = (id) => {
    router.push({ name: 'verPerfilMecanico', params: { id: id } })
}

onMounted(() => {
    getServicios();
    getPerfiles();
});
</script>

<style>
.rubroFilter {
    background: #242424;
    color: #FFFFFF;
    white-space: normal;
}

.rubroFilter .v-card-title {
    white-space: normal;
}

.servicio_card {
    border: #1279C1 solid 2px;
    background: linear-gradient(0deg, rgb(33, 33, 149)0%, rgb(18, 121, 193, 1) 100%);
    height: 100%;
}

.servicio_title {
    white-space: normal;
    min-height: 80px;
}

.busquedaPerfil {
    background-color: #303134;
    color: #FFFFFF;
}

.perfil-card {
    border: #242424 solid 3px;
    background: linear-gradient(to bottom right, #242424, #1279C1);
    color: #FFFFFF;
}

.card-body:hover {
    cursor: pointer !important;
}

.card-text:hover {
    cursor: pointer !important;
    background-color: #242424 !important;
}
</style>