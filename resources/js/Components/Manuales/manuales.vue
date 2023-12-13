<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Manuales de taller y propietario</h3>
        </div>

        <v-card class="bg-secondary text-white">
            <v-card-text>
                <v-form class="d-flex align-center">
                    <v-text-field hide-details="auto" label="Buscar por marca" prepend-inner-icon="mdi-car-search"
                        variant="solo" class="pr-3"></v-text-field>
                    <v-btn prepend-icon="mdi-trash-can" class="greyButton">
                        Limpiar
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
        <v-row class="mt-3">
            <v-col cols="12">
                <v-btn class="bg-primary" prepend-icon="mdi-book-plus-multiple" @click="newManual">Agregar
                    manual</v-btn>
            </v-col>
            <v-col cols="12">
                <v-data-table :items="items" :headers="headers">
                    <template v-slot:headers="{ columns }">
                        <tr>
                            <template v-for="column in columns" :key="column.key">
                                <td class="bg-primary">
                                    <span class="mr-2 cursor-pointer">{{ column.title }}</span>
                                </td>
                            </template>
                        </tr>
                    </template>
                    <template v-slot:item.acciones="{ item }">
                        <v-icon size="small" class="me-2">
                            mdi-eye
                        </v-icon>
                        <v-icon size="small" @click="editManual(item)">
                            mdi-pencil
                        </v-icon>
                        <v-icon size="small" @click="eliminarManual = true">
                            mdi-delete
                        </v-icon>
                    </template>
                    <template v-slot:no-data>
                        No hay Registros
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <v-dialog v-model="newEditDialog">
            <v-card class="bg-greyDark">
                <v-card-title>
                    <span class="text-h5 text-primary font-weight-bold">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>

                    <v-row>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.marca" label="Marca" color="primary"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.modelo" label="Modelo" color="primary"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.anio" label="Año" color="primary"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.tipoManual" label="Tipo de Manual"
                                color="primary"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.estado" label="Estado" color="primary"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-file-input label="Archivo" color="primary"></v-file-input>
                        </v-col>
                    </v-row>

                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-primary" prepend-icon="mdi-book-check" @click="save">
                        Guardar
                    </v-btn>
                    <v-btn prepend-icon="mdi-cancel" class="bg-error" @click="cancel">Cancelar</v-btn>

                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog width="auto" v-model="eliminarManual">
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Manual</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>¿Esta seguro de querer eliminar este manual?</v-card-text>
                <v-card-text class="pt-0">Esta accion sera irreversible</v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarManual = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-container>
</template>

<script setup>
import { ref, computed } from 'vue';

const eliminarManual = ref(false);
const newEditDialog = ref(false);
const editedItem = ref(
    {
        id: '',
        marca: "",
        modelo: "",
        anio: "",
        tipoManual: "",
        estado: "",
    }
);
const defaultItem = ref(
    {
        id: '',
        marca: "",
        modelo: "",
        anio: "",
        tipoManual: "",
        estado: "",
    },
);

const headers = ref([
    { title: 'N°', value: 'id' },
    { title: 'Marca', value: 'marca' },
    { title: 'Modelo', value: 'modelo' },
    { title: 'Año', value: 'anio' },
    { title: 'Tipo de manual', value: 'tipoManual' },
    { title: 'Estado', value: 'estado' },
    { title: 'Acciones', value: 'acciones' },

])
const items = ref([
    {
        id: '1',
        marca: 'Mitsubishi',
        modelo: 'L200',
        anio: '2000',
        tipoManual: 'Manual de taller',
        estado: 'Disponible',
    },
    {
        id: '2',
        marca: 'Honda',
        modelo: 'L202',
        anio: '2020',
        tipoManual: 'Manual de taller',
        estado: 'Disponible',
    },
])

const formTitle = ref('');

const newManual = () => {
    formTitle.value = 'Nuevo Manual';
    newEditDialog.value = true;
}

const editManual = (item) => {
    newEditDialog.value = true;
    formTitle.value = 'Editar Manual';
    editedItem.value = item;
}

const cancel = () => {
    newEditDialog.value = false;
    editedItem.value = defaultItem.value;
}

const save = () => {
    newEditDialog.value = false;
    editedItem.value = defaultItem.value;
}


</script>

<style></style>