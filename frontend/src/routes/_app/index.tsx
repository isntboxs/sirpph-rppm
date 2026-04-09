import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_app/')({ component: App })

function App() {
  return (
    <main>
      <h1>Home</h1>
    </main>
  )
}
