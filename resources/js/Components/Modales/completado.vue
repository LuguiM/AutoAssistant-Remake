<template>
    <v-dialog v-model="dialog" persistent width="auto">
       <template v-slot:activator="{ props }">
           <v-btn v-if="prop.type ==='text'" v-bind="props" class="bg-success"  prepend-icon="mdi-check-circle-outline">Completado</v-btn>
           <v-btn v-else-if="prop.type === 'icon'" v-bind="props" variant="flat" density="compact" icon="mdi-check-circle-outline"></v-btn>
       </template>
       

           <v-card class="text-center bg-greyDark">
               <v-card-title class="text-primary font-weight-bold">Completar servicio</v-card-title>
               <v-divider class="border-opacity-100" color="primary"></v-divider>
               <v-card-text class="text-h4"><v-icon color="success">mdi-check-circle-outline</v-icon></v-card-text>
               <v-card-text>¿Esta seguro de completar este servicio?</v-card-text>
               <v-card-text class="pt-0">Su estado cambiara a completado</v-card-text>

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
import { putData } from '@/plugins/api.js';



const dialog = ref(false);

const prop = defineProps({
   type: {
       type: String,
       required: true,
       default: 'icon'
   },
   id: {
       type: Number,
       required: true,
       default: null
   }

})
const emit = defineEmits(['actualizar'])


const form = ref({})

const aceptarServicio = async() =>{
   
   try{
       form.value.estado_id = 1;
       await putData(('updateEstado/' + prop.id),form.value, { headers: { 'Content-Type': 'application/json' } });
   }catch(error){
       notify(error,'error');
   }finally{
       dialog.value = false;
       emit('actualizar')
   }
}

</script>