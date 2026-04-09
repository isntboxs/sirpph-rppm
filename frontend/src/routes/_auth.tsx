import { Outlet, createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_auth')({
  component: RouteComponent,
})

function RouteComponent() {
  return (
    <div className="grid min-h-svh grid-cols-1 md:grid-cols-[3fr_2fr] lg:grid-cols-[4fr_2fr]">
      <div className="flex items-center justify-center bg-foreground bg-radial from-g4/60 to-g6/40 p-16 max-md:hidden">
        <div className="w-full space-y-2">
          <h1 className="text-6xl font-bold text-background">
            Si<span className="text-yellow-300">RPPH</span>
          </h1>

          <div className="text-background/80">
            <p>Sistem Informasi Penyusunan RPPM & RPPH</p>
            <p>PAUDQu AL-AULIA — Kota Serang</p>
          </div>
        </div>
      </div>

      <div className="flex items-center justify-center px-0 md:px-4 lg:px-0">
        <Outlet />
      </div>
    </div>
  )
}
