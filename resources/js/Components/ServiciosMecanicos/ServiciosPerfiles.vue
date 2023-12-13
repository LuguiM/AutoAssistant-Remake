<template>
    <v-container>
        <v-tabs v-model="tab" color="white" bg-color="primary" align-tabs="center">
            <v-tab value="servicios">
                <v-icon>mdi-car-wrench</v-icon>
                Servicios
            </v-tab>
            <v-tab value="perfiles">
                <v-icon>mdi-account</v-icon>
                Perfiles
            </v-tab>
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item value="servicios">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12" md="3">
                            <v-card class="rubroFilter" variant="outlined">
                                <v-card-title class="text-center">Rubros de talleres</v-card-title>
                                <v-card-text>
                                    <v-checkbox v-for="rubro in rubros" :label="rubro.label" :value="rubro.value"
                                        hide-details></v-checkbox>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="12" md="9">
                            <v-row>
                                <v-col v-for="servicio in serviciosMecanicos" cols="12" md="3">
                                    <v-card variant="outlined" class="servicio_card" @click="verServicio(servicio.id)">
                                        <v-img class="" :src="servicio.image"></v-img>

                                        <v-card-title class="servicio_title text-center pb-0">
                                            {{ servicio.servicio }}
                                        </v-card-title>
                                        <v-card-text>
                                            <div>
                                                <strong>Rubro:</strong> {{ servicio.rubro }}
                                            </div>
                                            <div>
                                                <strong>Tipo de servicio:</strong> {{ servicio.tipoServicio }}
                                            </div>
                                        </v-card-text>

                                        <v-card-text class="bg-primary">
                                            <div class="d-flex">
                                                <strong>Costo: $</strong> {{ servicio.costo }}
                                            </div>
                                        </v-card-text>

                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

            <v-window-item value="perfiles">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12">
                            <v-card class="busquedaPerfil mb-5">
                                <v-card-title class="text-center">
                                    Busqueda de perfiles
                                </v-card-title>

                                <v-card-Text>
                                    <v-form>
                                        <v-row>
                                            <v-col cols="12" md="8">
                                                <v-text-field label="Busqueda por nombre"
                                                    prepend-inner-icon="mdi-account-search"
                                                     variant="solo"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4" class="d-flex align-center justify-center mb-5">
                                                <v-btn variant="tonal" prepend-icon="mdi-magnify" class="mr-3 blueButton">
                                                    Buscar
                                                </v-btn>
                                                <v-btn variant="tonal" prepend-icon="mdi-trash-can" class="greyButton">
                                                    Limpiar
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-Text>
                            </v-card>

                            <v-row>
                                <v-col cols="12" md="3" v-for="perfil in perfiles">
                                    <v-card class="text-center perfil-card" @click="verPerfil(perfil.id)">
                                        <v-avatar color="grey" size="190" class="mt-4">
                                            <v-img cover :src="perfil.img"></v-img>
                                        </v-avatar>

                                        <v-card-text>
                                            <v-icon>mdi-account</v-icon>
                                            Representante: {{ perfil.representante }}
                                        </v-card-text>
                                        <v-card-text class="pt-0">
                                            <v-icon>mdi-car-cog</v-icon>
                                            Taller Mecanico: {{ perfil.tallerMecanico }}
                                        </v-card-text>

                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
        </v-window>
    </v-container>
</template>



<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

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
const serviciosMecanicos = ref([
    {
        id: "1",
        image: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        servicio: "Cambio de alternador",
        rubro: "Lubricentro",
        tipoServicio: "Cita/Reserva",
        costo: "123",
    },
    {
        id: "2",
        image: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        servicio: "Cambio de aceite",
        rubro: "Lubricentro",
        tipoServicio: "Cita/Reserva",
        costo: "123",
    },
    {
        id: "3",
        image: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        servicio: "Cambio de luces",
        rubro: "Lubricentro",
        tipoServicio: "Cita/Reserva",
        costo: "123",
    },
    {
        id: "4",
        image: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        servicio: "Cambio de alternador",
        rubro: "Lubricentro",
        tipoServicio: "Cita/Reserva",
        costo: "123",
    },
    {
        id: "5",
        image: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        servicio: "Cambio de alternador",
        rubro: "Lubricentro",
        tipoServicio: "Cita/Reserva",
        costo: "123",
    },
]);
const perfiles = ref([
    {
        img: 'https://cdn.vuetifyjs.com/images/profiles/marcus.jpg',
        representante: 'Kerin Melendez',
        tallerMecanico: 'Taller Melendeez',
        id: '1'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/profiles/marcus.jpg',
        representante: 'Kerin Melendez',
        tallerMecanico: 'Taller Melendeez',
        id: '2'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/profiles/marcus.jpg',
        representante: 'Kerin Melendez',
        tallerMecanico: 'Taller Melendeez',
        id: '3'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/profiles/marcus.jpg',
        representante: 'Kerin Melendez',
        tallerMecanico: 'Taller Melendeez',
        id: '4'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/profiles/marcus.jpg',
        representante: 'Kerin Melendez',
        tallerMecanico: 'Taller Melendeez',
        id: '5'
    },
]);

const verServicio = (id) => {
    router.push({ path: `/verServicio/${id}` });
}

const verPerfil = (id) => {
    router.push({ path: `/perfilMecanico/${id}` });
}
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
</style>