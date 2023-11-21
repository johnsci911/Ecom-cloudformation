<script setup>
import { onMounted, computed, ref } from 'vue'
import { useFlash } from "@/composables/useFlash"

let { flash } = useFlash()

const products = ref([])

let cart = ref([])

onMounted(() => {
  fetch('http://18.234.82.38:8000/graphql', {
    method: 'post',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify({
      query: `
        query {
          products {
            data {
              id
              name
              description
              price
            }
          }
        }
      `
    })
  })
  .then(response => response.json())
  .then(result => {
    products.value = result.data.products.data
  })
})

let addToCart = (product) => {
  cart.value.push({
    product_id: product.id,
    product_name: product.name,
    product_description: product.description,
    product_price: product.price
  })

  cart.value = [...new Map(cart.value.map(item => [item['product_id'], item])).values()]
}

let removeFromCart = (product_id) => {
  cart.value = cart.value.filter(item => item.product_id != product_id)
}

let placeOrder = (cart, user_id, user_email) => {
  fetch('http://18.234.82.38:8002/graphql', {
    method: 'post',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify({
      query: `
        mutation {
          createCheckout(
            user_id: "${user_id}"
            cart: "\"${JSON.stringify(JSON.stringify(cart))}\""
          ) {
            id
            user_id
            cart
          }
        }
      `
    })
  })
  .then(response => response.json())
  .then(result => {
    // console.log(result.data.createCheckout.cart.replace(/\\/g,""))
  })

  var totalPrice = cart.reduce((sum, object) => (eval(`${sum} + ${object.product_price}`)), 0)

  fetch('http://18.234.82.38:8004/graphql', {
    method: 'post',
    headers: {
      'Content-type': 'application/json'
    },
    body: JSON.stringify({
      query: `
        mutation {
          createEmail(
            user_id: "${user_id}",
            cart: "\"${JSON.stringify(JSON.stringify(cart))}\"",
            user_email: "${user_email}",
            total: "${totalPrice}",
          ) {
            id
            user_id
            user_email
            cart
            total
            created_at
            updated_at
          }
        }
      `
    })
  })
  .then(response => response.json())
  .then(result => {
    // flash('Order is placed')
    console.log(result)
  })
}
</script>

<template>
  <main>
    <div class="flex flex-row bg-gray-700">
      <div class="bg-gray-800 rounded-lg p-3 m-4 w-3/4 grid grid-cols-3 gap-4">
        <div class="bg-gray-900 p-4 rounded-lg border-none text-white flex flex-row justify-between gap-4" v-for="product in products" :key="product.id">
          <div class="grid gap-y-4 w-full">
            <h3 class="text-xl">Product: {{ product.name }}</h3>
            <h4 class="text-sm">{{ product.description }}</h4>
            <div class="flex flex-row">
              <strong>Price</strong><p class="ml-3">{{ product.price }}</p>
            </div>
            <div class="mx-auto w-full text-center">
              <button class="px-3 py-2 bg-blue-900 rounded-lg hover:bg-green-800" @click="addToCart(product)">Checkout</button>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-800 my-4 mr-4 rounded-lg w-1/4">
        <div class="flex flex-row justify-between">
          <h1 class="text-gray-100 text-2xl p-4 align-middle">Cart</h1>
          <button class="text-white text-md px-3 py-2 m-4 bg-green-900 rounded-lg" @click="placeOrder(cart, '1', 'test@user.com')">Place order</button>
        </div>

        <ul class="bg-gray-800 rounded-lg mx-4 grid gap-y-4">
          <li class="bg-gray-900 p-4 rounded-lg border-none text-white flex flex-row justify-between gap-4" v-for="item in cart" :key="item.product_id">
            <div class="flex flex-col">
              <h3 class="text-xl">{{ item.product_name }}</h3>
              <p class="text-xs pt-2">{{ item.product_description }}</p>
              <p class="text-md pt-3">Price: {{ item.product_price }}</p>
            </div>
            <div class="grid content-end">
              <button class="btn bg-red-900 py-1 px-2 rounded-lg text-md" @click="removeFromCart(item.product_id)">Remove</button>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </main>
</template>
