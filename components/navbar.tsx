'use client'

import { useState } from 'react'
import Link from 'next/link'
import { useAuth } from '@/components/auth-provider'
import { AuthDialog } from '@/components/auth-dialog'
import { Button } from '@/components/ui/button'
import { BarChart3, LogOut, User } from 'lucide-react'

export function Navbar() {
  const { user, signOut, isLoading } = useAuth()
  const [showAuthDialog, setShowAuthDialog] = useState(false)

  const handleSignOut = () => {
    signOut()
  }

  return (
    <>
      <nav className="border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 sticky top-0 z-40">
        <div className="container mx-auto px-4 py-2 max-w-6xl">
          <div className="flex items-center justify-between">
            <Link href="/" className="flex items-center space-x-2 hover:opacity-80 transition-opacity">
              <div className="w-6 h-6 sm:w-8 sm:h-8 bg-black rounded text-white flex items-center justify-center font-bold text-sm sm:text-base">
                C
              </div>
              <span className="text-lg sm:text-xl font-bold">Clyk</span>
            </Link>

            <div className="flex items-center space-x-2 sm:space-x-4">
              {isLoading ? (
                <div className="w-12 sm:w-16 h-8 bg-gray-200 rounded animate-pulse" />
              ) : user ? (
                <>
                  <Link href="/dashboard">
                    <Button variant="ghost" size="sm" className="hidden sm:flex h-8">
                      <BarChart3 className="mr-2 h-3 w-3" />
                      Dashboard
                    </Button>
                    <Button variant="ghost" size="sm" className="sm:hidden h-8 w-8 p-0">
                      <BarChart3 className="h-4 w-4" />
                    </Button>
                  </Link>
                  
                  <div className="flex items-center space-x-2">
                    <div className="hidden sm:flex items-center space-x-2">
                      {user.avatar && (
                        <img 
                          src={user.avatar} 
                          alt={user.name}
                          className="w-5 h-5 rounded-full"
                        />
                      )}
                      <span className="text-xs text-muted-foreground max-w-20 truncate">
                        {user.name}
                      </span>
                    </div>
                    <Button
                      onClick={handleSignOut}
                      variant="outline"
                      size="sm"
                      className="hidden sm:flex h-8"
                    >
                      <LogOut className="mr-2 h-3 w-3" />
                      Sign Out
                    </Button>
                    <Button
                      onClick={handleSignOut}
                      variant="outline"
                      size="sm"
                      className="sm:hidden h-8 w-8 p-0"
                    >
                      <LogOut className="h-4 w-4" />
                    </Button>
                  </div>
                </>
              ) : (
                <>
                  <Button
                    onClick={() => setShowAuthDialog(true)}
                    variant="outline"
                    size="sm"
                    className="hidden sm:flex h-8"
                  >
                    <User className="mr-2 h-3 w-3" />
                    Sign In
                  </Button>
                  <Button
                    onClick={() => setShowAuthDialog(true)}
                    variant="outline"
                    size="sm"
                    className="sm:hidden h-8 w-8 p-0"
                  >
                    <User className="h-4 w-4" />
                  </Button>
                </>
              )}
            </div>
          </div>
        </div>
      </nav>

      <AuthDialog 
        isOpen={showAuthDialog}
        onClose={() => setShowAuthDialog(false)}
      />
    </>
  )
}