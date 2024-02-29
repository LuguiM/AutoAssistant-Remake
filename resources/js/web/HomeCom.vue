<template>
    <v-container>
        <v-row id="inicio" align="center" class="my-4">
            <v-col cols="12" class="text-center">
                <h1 class="rounded-lg my-14 font-weight-black">¿Necesitas <br> ayuda con tu <br> vehiculo?</h1>
                <h1 class="rounded-lg my-14 font-weight-black">¿Deseas un lugar <br> para brindar tus <br> servicios
                    mecanicos?</h1>

            </v-col>
            <v-col cols="12" class="text-center d-flex justify-center align-center">
                <div data-aos="zoom-in">
                    <v-card class="back-question text-center elevation-24 my-14 pa-3 px-sm-15">
                        <v-img src="../images/Logos/sinLetrasLogo.png" height="150"></v-img>
                        <h1 class="text-white ">AutoAssistant</h1>
                    </v-card>
                </div>

            </v-col>
            <v-col cols="12">
                <div class="my-15" data-aos="fade-up"
                data-aos-easing="ease-out-cubic"
                data-aos-duration="2000">
                <v-card class="pa-5 bg-primary rounded-shaped" variant="outlined">
                    <h1>¿AutoAssistant?</h1>
                    <hr>
                    <h3 class="text-justify font-weight-regular">
                        Autoassistant tu mecánico virtual, con las funciones que te ayudaran a solucionar las problemáticas de
                        tu vehículo, brindándote funciones en las que puedas acceder a la información que brinda para los
                        conductores y el registro o ingreso para talleres mecánicos o mecánicos independientes para que puedan
                        inscribirse y poder ofrecer servicios a los conductores.
                    </h3>
                </v-card>
            </div>
            </v-col>
        </v-row>

        <div id="nosotros" data-aos="fade-up" data-aos-easing="ease-out-cubic"
                data-aos-duration="1500" class="my-15 d-flex flex-column flex-sm-row gap-10 bg-terceary pa-3 rounded-shaped outlined" style="border: 1px solid #FFFFFF;">
            <div>
                <v-img src="../images/Logos/logoequipo.png" alt="logoEquipo" width="300"></v-img>
            </div>
            <div class="">
                <h1>Sobre Nosotros</h1>
                    <hr>
                    <h3 class="text-justify font-weight-regular">
                        Somos Dragón Devs desarrolladores de la aplicación AutoAssistant, como equipo multifuncional con conocimientos en las diferentes áreas para la creación de esta aplicación, usando estos conocimientos para el mejor desempeño de la aplicación, utilizando todas nuestras destrezas y fortalezas para hacer su experiencia agradable.
                    </h3>
            </div>
        </div>

        <div class="my-15" style="color:transparent;">espacio</div>

        <div id="servicios" class="my-15">
            <h1 class="my-15 text-center">| Nuestos Servicios |</h1>
            <div class="d-flex flex-wrap justify-center" style="gap:15px;" >

                    <v-card class="text-center bg-white" variant="outlined" v-for="(card, index) in cards" :key="index" width="300">
                        <v-card-text>
                            <v-img :src="card.src" alt="logoEquipo" height="150"></v-img>
                        </v-card-text>

                        <v-card-title>{{card.title}}</v-card-title>

                        <v-card-text>
                            {{card.description}}
                        </v-card-text>
                    </v-card>

            </div>
        </div>


    </v-container>
</template>
<script setup>
import { ref } from 'vue';

const cards = ref([
    {
        src: "../images/tallermecanicos.png",
        title: "Inscripcion de Servicios Mecanicos",
        description: "Los talleres mecánicos y mecánicos independientes podrán inscribir sus servicios."
    },
    {
        src: "../images/pilotos1.png",
        title: "Pilotos",
        description: "Encuentra el piloto que usted necesite y información del mismo con una posible solución."
    },
    {
        src: "../images/serviciosme.png",
        title: "Servicios Mecanicos",
        description: "Los conductores y futuros conductores podran observar los servicios mecanicos que se ofrecen en AutoAssistant y asi mismo poder contratarlos"
    },
])

</script>
<style>
.back-question {
    background: transparent;
    backdrop-filter: blur(30px);
    border: 1px solid #FFFFFF;
}</style>