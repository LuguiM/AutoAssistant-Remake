<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Inscripcion de servicios</h3>
        </div>

        <v-expansion-panels>
            <v-expansion-panel class="bg-primary">
                <v-expansion-panel-title>Requisitos de Mecanicos</v-expansion-panel-title>
                <v-expansion-panel-text>
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
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>

        <v-btn block class="mt-5 bg-primary" prepend-icon="mdi-car-wrench" :to="{ path: '/inscribirServicio' }">
            Inscribir servicio mecanico
        </v-btn>

        <v-row class="mt-5">
            <v-col cols="12">
                <h2>Servicios Inscritos</h2>
            </v-col>

            <v-col cols="12" sm="6">
                <v-card class="inscritoCard">
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-img style="height: 100%;" class=""
                                src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
                        </v-col>

                        <v-col cols="12" md="8">

                            <v-card-title class="text-h5 font-weight-bold item-texto">
                                Intermitente y luces de emergencia
                            </v-card-title>
                            <v-card-subtitle>
                                Creado: 12/09/2023
                            </v-card-subtitle>

                            <v-card-actions class="text-center">
                                <v-btn class=" bg-primary" prepend-icon="mdi-square-edit-outline">
                                    Modificar
                                </v-btn>
                                <v-btn class="bg-error" prepend-icon="mdi-delete-outline  ">
                                    Eliminar
                                </v-btn>
                            </v-card-actions>

                        </v-col>
                    </v-row>
                </v-card>

            </v-col>
            <v-col cols="12" sm="6">
                <v-card class="inscritoCard">
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-img style="height: 100%;" class=""
                                src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
                        </v-col>

                        <v-col cols="12" md="8">

                            <v-card-title class="text-h5 font-weight-bold item-texto">
                                Intermitente y luces de emergencia
                            </v-card-title>
                            <v-card-subtitle>
                                Creado: 12/09/2023
                            </v-card-subtitle>

                            <v-card-actions class="text-center">
                                <v-btn class=" bg-primary" prepend-icon="mdi-square-edit-outline">
                                    Modificar
                                </v-btn>
                                <v-btn class="bg-error" prepend-icon="mdi-delete-outline  ">
                                    Eliminar
                                </v-btn>
                            </v-card-actions>

                        </v-col>
                    </v-row>
                </v-card>

            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

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


</script>

<style>
.v-expansion-panel-text__wrapper {
    background-color: #D9D9D9 !important;
}

.itemsRequisitos {
    background-color: #D9D9D9;
    border: #c6c4c4 solid 1px;

}

.item-texto {
    white-space: normal !important;
}

.inscritoCard {
    background-color: #D9D9D9;
}
</style>