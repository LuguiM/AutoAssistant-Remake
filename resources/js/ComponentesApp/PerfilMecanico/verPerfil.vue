<template>
    <v-overlay class="align-center justify-center" v-if="loading" :model-value="loading">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <v-container v-else-if="!status">
        <v-alert color="error" icon="$error" :text="message">
        </v-alert>
    </v-container>


    <v-container v-else-if="status">

        <div class="text-center mb-5 text-uppercase">
            <h3>Perfil de Mecanico</h3>
        </div>

        <v-row>
            <v-col cols="12">
                <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
            </v-col>
            <v-col cols="12" sm="4">
                <v-card class="text-white bg-secondary">
                    <v-card-title class="text-center font-weight-bold mb-3">
                        <v-icon>mdi-account-circle</v-icon>
                        Información
                    </v-card-title>
                    <v-card-text class="d-flex justify-center">
                        <v-img :width="300" aspect-ratio="1/1" cover
                            :src="infoPerfil.logo"></v-img>
                    </v-card-text>
                    <v-card-text class="mx-5">
                        <v-row>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Nombre del taller:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>{{ infoPerfil.nombre_taller }}</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Nombre del representante:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>{{ infoPerfil.representante }}</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Numero de contacto:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>{{ infoPerfil.numero }}</p>
                            </v-col>
                            <v-col cols="12" md="6" v-if="infoPerfil.direcion !== null">
                                <p class="font-weight-bold">Direccion:</p>
                            </v-col>
                            <v-col cols="12" md="6" v-if="infoPerfil.direcion !== null">
                                <p>{{ infoPerfil.direcion }}</p>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" sm="8">
                <v-card>
                    <v-card-title class="text-center font-weight-bold">
                        <v-icon>mdi-car-cog</v-icon>
                        Servicios
                    </v-card-title>


                    <v-list lines="two" v-if="infoPerfil.servicios.length">
                        <v-list-item class="pb-0" v-for="servicio in infoPerfil.servicios" >
                            <v-card class="text-center perfil-card" hover>
                                <div @click="verServicio(servicio.id)" class="card-body">
                                    <v-row>
                                        <v-col cols="12" md="4">
                                            <v-avatar color="grey" size="120" class="mt-4">
                                                <v-img cover :src="servicio.image"></v-img>
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
                                                    {{ servicio.tipoServicio }}
                                                </div>
                                                <div>
                                                    <v-icon>mdi-currency-usd</v-icon> {{ servicio.costo }}
                                                </div>
                                            </v-card-text>
                                        </v-col>
                                    </v-row>
                                </div>
                                <v-card-actions v-if="prop.mode == 'conductor'"
                                    class="bg-primary card-text d-flex justify-center" @click="verPerfil(servicio.id)">
                                    <v-avatar color="info" size="x-small">
                                        <v-img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John"></v-img>
                                    </v-avatar>
                                    <p> Taller Melendez</p>
                                </v-card-actions>

                            </v-card>
                        </v-list-item>
                       

                    </v-list>
                    <v-alert v-else class="m-9" variant="tonal" color="error"  text="No se encontraron servicios disponiblees">
                        </v-alert>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import notify from '@/plugins/notify.js';
import { getData } from '@/plugins/api.js';


const router = useRouter();
const prop = defineProps({
    mode: {
        type: String,
        required: true,
        default: 'conductor'
    },
    id: {
        type: Number,
        required: false,
        default: null
    }

})

const infoPerfil = ref({});

const loading = ref(true);
const status = ref(false)
const message = ref('');

const perfilMecanico = async (id) => {
    try {
        const data = await getData(('perfilMecanico/' + id));
        status.value = data.status;
        infoPerfil.value = data.data;
        console.log('data', infoPerfil.value)

        if (!data.status) {
            status.value = data.status
            message.value = data.message
        }
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
}

const verServicio = (id) => {
    router.push({ path: `/verServicio/${id}` });
}

const verPerfil = (id) => {
    router.push({ path: `/perfilMecanico/${id}` });
}


onMounted(() => {
    if (prop.id = ! null) {
        perfilMecanico(prop.id)
    } else {
        perfilMecanico(router.params.id)
    }
});
</script>

<style>
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