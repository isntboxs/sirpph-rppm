import { Outlet, createFileRoute, redirect } from '@tanstack/react-router'

import { userQueryOptions } from '#/lib/api'

export const Route = createFileRoute('/_app')({
  component: RouteComponent,
  beforeLoad: async ({ context, location }) => {
    if (location.pathname === '/sign-in') return

    const session =
      await context.queryClient.ensureQueryData(userQueryOptions())

    if ('message' in session) {
      throw redirect({
        to: '/login',
        search: {
          redirect: location.pathname,
        },
      })
    }
  },
})

function RouteComponent() {
  return (
    <div>
      <Outlet />
    </div>
  )
}
