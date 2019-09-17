export const menus = [
  {
    id: 'dashboard',
    text: 'Dashboard',
    link: '/'
  },
  {
    id: 'products',
    text: 'Products',
    children: [
      {
        id: 'products.list',
        text: 'List Products',
        link: '#/products'
      },
      {
        id: 'products.create',
        text: 'Add Product',
        link: '#/products/create'
      }
    ]
  }
]

// export const configs = [
//   {
//     id: 'configs',
//     text: 'Configurações',
//     children: [
//       {
//         id: 'default-values-add',
//         text: 'Valores Padrões',
//         link: '/configs/valores-padroes'
//       }
//     ]
//   }
// ]
