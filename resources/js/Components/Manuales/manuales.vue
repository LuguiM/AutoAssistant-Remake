<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Manuales de taller y propietario</h3>
        </div>

        <v-card class="bg-secondary text-white">
            <v-card-text>
                <v-form class="d-flex align-center">
                    <v-text-field hide-details="auto" label="Buscar por marca" prepend-inner-icon="mdi-car-search"
                        variant="outlined" class="pr-3"></v-text-field>
                    <v-btn prepend-icon="mdi-trash-can" class="greyButton">
                        Limpiar
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
        <v-row class="mt-3">
            <v-col cols="12">
                <v-btn class="bg-primary" prepend-icon="mdi-book-plus-multiple" @click="newEditDialog = true">Agregar
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
                        <v-icon size="small" @click="deleteManual(item)">
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
            <v-card>
                <v-card-title>
                    <span class="text-h5">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.marca" label="Marca"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.modelo" label="Modelo"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.anio" label="Año"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.tipoManual" label="Tipo de Manual"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.estado" label="Estado"></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text">
                        Cancel
                    </v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="save">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-container>
</template>

<script setup>
import { ref, computed } from 'vue';


const newEditDialog = ref(false);
const editedIndex = ref(-1);
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

const formTitle = computed(() => {
    return editedIndex.value === -1 ? 'Nuevo Manual' : 'Editar Manual'
})

const editManual = (item) => {
    editedIndex.value = items.indexOf(item)
    editedItem.value = Object.assign({}, item)
    newEditDialog.value = true;
}

const save = () => {
    if (editedIndex.value > -1) {
        Object.assign(items.value[editedIndex.value], editedItem.value)
    } else {
        items.value.push(editedItem.value)
    }
    newEditDialog.value = false;
}


</script>

<style></style>