<template>
     <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }">
            <v-btn v-if="prop.type ==='text'" v-bind="props" class="bg-primary"  prepend-icon="mdi-check-circle-outline">Aceptar</v-btn>
            <v-btn v-else-if="prop.type === 'icon'" v-bind="props" variant="flat" density="compact" icon="mdi-check-circle-outline"></v-btn>
        </template>
        

            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Aceptar servicio</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>¿Esta seguro de aceptar este servicio?</v-card-text>

                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary" @click="aceptarServicio">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="dialog = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        
    </v-dialog>
</template>


<script setup>
import {ref, defineProps} from 'vue'
import notify from '@/plugins/notify.js'


const dialog = ref(false);

const prop = defineProps({
    type: {
        type: String,
        required: true,
        default: 'icon'
    }

})

const aceptarServicio = () =>{
    notify(`Se ha activado el servicio correctamente`, 'success')
    dialog.value = false
}

</script>