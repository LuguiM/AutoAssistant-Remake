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
                                    <v-checkbox v-for="rubro in rubros" :label="rubro.label" :value="rubro.value"
                                        hide-details></v-checkbox>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn variant="tonal" prepend-icon="mdi-magnify" class="mr-3 blueButton">
                                        Filtrar
                                    </v-btn>
                                    <v-btn variant="tonal" prepend-icon="mdi-trash-can" class="greyButton">
                                        Limpiar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                        <v-col cols="12">
                            <v-row>
                                <v-col v-for="servicio in serviciosMecanicos" cols="12" sm="6" md="6">
                                    <v-card class="text-center perfil-card">
                                        <div @click="verServicio(servicio.id)" class="card-body">
                                            <v-row>
                                                <v-col cols="12" md="4">
                                                    <v-avatar color="grey" size="120" class="mt-4">
                                                    <v-img cover :src="servicio.image"></v-img>
                                                    </v-avatar>
                                                </v-col>
                                                <v-col cols="12" md="8">
                                                    <v-card-title class="text-start">
                                                        {{ servicio.servicio}}
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
                                        <v-card-actions class="bg-primary card-text d-flex justify-center" @click="verPerfil(servicio.id)">
                                                <v-avatar color="info" size="x-small">
                                                    <v-img
                                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                        alt="John"
                                                    ></v-img>
                                                </v-avatar> 
                                                <p> Taller Melendez</p>
                                        </v-card-actions>

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
        tipoServicio: "Adomicilio",
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
        tipoServicio: "Adomicilio",
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
        tipoServicio: "Adomicilio",
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
.card-body:hover{
    cursor: pointer !important;
}

.card-text:hover{
    cursor: pointer !important;
    background-color: #242424 !important;
}
</style>